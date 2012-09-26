#!/usr/bin/perl

use strict;
use warnings;
use DBI;
use Data::Dumper;
use Smart::Comments;

&run() unless caller();

my $dbi;

sub run {
    opendir(D, $ARGV[0]);
    my @files = sort grep { /[^.]/ } grep { !-d } readdir D;
    close D;


    my $counts_of = {}; # { filename => { comp => 0, noncomp => 0 }}

    if (scalar(@files)) {
        #$dbi = DBI->connect('dbi:mysql:database=trost;host=gent', 'trost', 'passwordpas');
        $dbi = DBI->connect('dbi:mysql:database=trost_prod;host=localhost', 'root', 'password');
        &test_file_count(\@files);
        my $dbi_counts_of = $dbi->selectall_hashref(q{SELECT lower(filename) as filename, count(*) as phen_samples,  count(distinct phenotypes.sample_id) as uniq_phen_samples FROM raws JOIN phenotype_raws ON raw_id = raws.id join phenotypes on phenotypes.id = phenotype_raws.phenotype_id GROUP BY filename}, 'filename');
        print "FILENAME:\t\t\tDBI\t\t!COMP\t\tBBCH\t\tCOMP\t\tPLANTS\t\tSAMPLES\n";
        for my $file (@files) {
#            next if $file ne 'trost_2012_01_11_2.txt';
            my $fh = open(F, '<', $ARGV[0] . $file);
            my @lines = <F>;
            close F;

            $file = lc $file;
            $counts_of->{ $file } = {};
            my @comp = grep {/component/} @lines;
            my @bbch = grep {/BBCH/} @lines;
            $counts_of->{ $file }->{ bbch    } = scalar @bbch;
            $counts_of->{ $file }->{ comp    } = scalar @comp;
            $counts_of->{ $file }->{ noncomp } = scalar(@lines) - scalar @comp;
            $counts_of->{ $file }->{ total   } = scalar @lines;
            $counts_of->{ $file }->{ plants  } = {};
            $counts_of->{ $file }->{ samples } = {};
            $counts_of->{ $file }->{ bbch_samples } = {}; # the sample ids when a line has BBCH program
            $counts_of->{ $file }->{ phen_samples } = {}; # the sample ids when a line has Fast Score program (without sample/plant files)
            $counts_of->{ $file }->{ comp_samples } = {}; # the sample ids for sample/plants files

            # count the plants and samples (as explicitely mentioned in the file)
            if (scalar @comp) {
                for my $line (@comp) {
                    $line =~ m/.*id(;|\t)(\d+)(;|\t)(\d+)(;|\t).*/;
                    $counts_of->{ $file }->{ plants  }->{ $4 } = 1;
                    $counts_of->{ $file }->{ samples }->{ $2 } = 1;
                }
            }

            # count samples names in the phenotype (for each phenotype there is a sample)
            my @noncomp = grep { !/component/ } grep { !/BBCH/ } @lines;
            for my $line (@noncomp) {
                my @sample_name = split /;|\t/, $line;
                $counts_of->{ $file }->{ phen_samples }->{ $sample_name[7] } = 1;
            }
            for my $line (@bbch) {
                my @sample_name = split /;|\t/, $line;
                $counts_of->{ $file }->{ bbch_samples }->{ $sample_name[3] } = 1;
            }
            for my $line (@comp) {
                my @sample_name = split /;|\t/, $line;
                $counts_of->{ $file }->{ comp_samples }->{ $sample_name[7] } = 1;
            }

            #test
            #for my $line (@lines) {
            #    my @sample_name = split /;|\t/, $line;
            #    if ($sample_name[7] eq '22' || $sample_name[3] eq '22') {
            #        print $file, ': ', $line;
            #    }
            #}


            my $dbi_count = defined $dbi_counts_of->{ $file }->{ phen_samples } ? $dbi_counts_of->{ $file }->{ phen_samples } : 0;
            if ($dbi_count != $counts_of->{ $file }->{ noncomp }) {
                print '*';
            }

            print "$file:\t\t$dbi_count\t\t";
            print "$counts_of->{ $file }->{ noncomp }\t\t";
            print "$counts_of->{ $file }->{ bbch }\t\t";
            print "$counts_of->{ $file }->{ comp }\t\t";
            print scalar keys %{ $counts_of->{ $file }->{ plants  } }, "\t\t";
            print scalar keys %{ $counts_of->{ $file }->{ samples } }, "\t\t";
            print "\n";
        }

        print "\n\n";
        my $uniq_plants = &count_uniq_plants($counts_of);
        my $dbi_plants = &count_dbi_plants();
        my $unconnected_plants = &count_unconnected_plants();
        print "# uniq plants = # DBI plants (- unconnected plants -1 placeholder)\n";
        print $uniq_plants;
        print ' = ';
        print $dbi_plants, ' - ', $unconnected_plants,' - 1 (', ($dbi_plants - $unconnected_plants - 1), ")\n";
        print "# uniq phen samples = # DBI phen samples\n";
        print &count_uniq_pheno_samples($counts_of);
        print ' = ';
        print &count_uniq_pheno_dbi_samples(), "\n";
        print "# DBI samples = # uniq phen samples + # unconnected DBI samples\n";
        print &count_dbi_samples();
        print ' = ';
        print &count_uniq_pheno_samples($counts_of);
        print ' + ';
        print &count_unconnected_samples(), "\n";
        print "# components\n";
        print &count_lines($counts_of, 'comp'), "\n";
        print "# samples = # uniq samples\n";
        print &count_samples($counts_of);
        print ' = ';
        print &count_uniq_samples($counts_of), "\n";
        print "# lines = # DBI phenotypes = # DBI summed phen\n";
        print (&count_lines($counts_of) - &count_comp_lines($counts_of));
        print ' = ';
        print &count_dbi_phenotypes();
        print ' = ';
        print &sum_dbi_phen_samples($dbi_counts_of), "\n";

        print "\n\n\n\n";
        #print Dumper &list_samples_not_db(&list_uniq_pheno_samples($counts_of));
    }
}

sub sum_dbi_phen_samples {
    my $dbi_counts_of = $_[0];

    my $total = 0;
    for my $file (keys %$dbi_counts_of) {
        if (exists($dbi_counts_of->{ $file }->{ phen_samples })) {
            $total += $dbi_counts_of->{ $file }->{ phen_samples };
        }
    }

    return $total;
}

sub sum_dbi_uniq_phen_samples {
    my $dbi_counts_of = $_[0];

    my $total = 0;
    for my $file (keys %$dbi_counts_of) {
        $total += $dbi_counts_of->{ $file }->{ uniq_phen_samples };
    }

    return $total;
}

sub count_dbi_phenotypes {
    return $dbi->selectrow_arrayref(q{SELECT count(*) from phenotypes})->[0];
}

sub count_lines {
    my $counts_of = $_[0];
    my $type = $_[1] || 'total';

    my $total = 0;
    for my $file (keys %$counts_of) {
        if (exists($counts_of->{ $file }->{ $type })) {
            $total += $counts_of->{ $file }->{ $type };
        }
    }

    return $total;
}

sub count_bbch_lines {
    return &count_lines($_[0], 'bbch');
}

sub count_comp_lines {
    return &count_lines($_[0], 'comp');
}

sub count_unconnected_samples {
    return $dbi->selectrow_arrayref(q{SELECT count(*) from samples left join phenotypes on samples.id = phenotypes.sample_id where phenotypes.id is null;})->[0];
}

sub count_unconnected_plants {
    return $dbi->selectrow_arrayref(q{SELECT count(distinct plants.id) from plants left join samples on plants.id = samples.plant_id where samples.id is null;})->[0];
}

sub count_plants {
    my $counts_of = $_[0];

    my $total = 0;
    for my $file (keys %$counts_of) {
        $total += scalar keys %{ $counts_of->{ $file }->{ plants } };
    }

    return $total;
}

sub count_uniq_plants {
    my $counts_of = $_[0];

    my $total = 0;
    my $uniq = {};
    for my $file (keys %$counts_of) {
        for my $plant (keys %{ $counts_of->{ $file }->{ plants } }) {
            $uniq->{ $plant } += 1;
        }
    }

    return scalar keys %$uniq;
}

sub count_uniq_samples {
    my $counts_of = $_[0];

    my $uniq = {};
    for my $file (keys %$counts_of) {
        for my $plant (keys %{ $counts_of->{ $file }->{ samples } }) {
            $uniq->{ $plant } += 1;
        }
    }

    return scalar keys %$uniq;
}

sub count_samples {
    my $counts_of = $_[0];

    my $total = 0;
    for my $file (keys %$counts_of) {
        $total += scalar keys %{ $counts_of->{ $file }->{ samples } };
    }

    return $total;
}

sub count_pheno_samples {
    my $counts_of = $_[0];

    my $total = 0;
    for my $file (keys %$counts_of) {
        $total += scalar keys %{ $counts_of->{ $file }->{ phen_samples } };
    }

    return $total;
}

sub count_uniq_pheno_samples {
    return scalar @{ &list_uniq_pheno_samples };
}

sub list_uniq_pheno_samples {
    my $counts_of = $_[0];

    my $uniq = {};
    for my $file (keys %$counts_of) {
        for my $phen (keys %{ $counts_of->{ $file }->{ phen_samples } }) {
            $uniq->{ $phen } += 1;
        }
        for my $phen (keys %{ $counts_of->{ $file }->{ bbch_samples } }) {
            $uniq->{ $phen } += 1;
        }
        # don't store these as phenotypes no-more
        #for my $phen (keys %{ $counts_of->{ $file }->{ comp_samples } }) {
        #    $uniq->{ $phen } += 1;
        #}
    }

    my @uniq_samples = keys %$uniq;
    return \@uniq_samples;
}

sub diff_dbi_samples {
    my $counts_of = $_[0];
    my $dbi_uniq_phen_samples = $dbi->selectall_hashref(q{SELECT distinct samples.id FROM samples JOIN phenotypes ON phenotypes.sample_id = samples.id}, 'id');
    my $uniq_phen_samples = &list_uniq_pheno_samples($counts_of);

    my @not_found = ();
    for my $dbi_sample (keys %$dbi_uniq_phen_samples) {
        my $found = 0;
        for my $sample (@$uniq_phen_samples) {
            if ($sample eq $dbi_sample) {
                $found = 1;
                next;
            }
        }

        push @not_found, $dbi_sample if !$found;
    }

    return \@not_found;
}

sub diff_samples {
    my $counts_of = $_[0];
    my $dbi_uniq_phen_samples = $dbi->selectall_hashref(q{SELECT distinct samples.id FROM samples JOIN phenotypes ON phenotypes.sample_id = samples.id}, 'id');
    my $uniq_phen_samples = &list_uniq_pheno_samples($counts_of);

    my @not_found = ();
    for my $sample (@$uniq_phen_samples) {
        my $found = 0;
        for my $dbi_sample (keys %$dbi_uniq_phen_samples) {
            if ($sample eq $dbi_sample) {
                $found = 1;
                next;
            }
        }

        push @not_found, $sample if !$found;
    }

    return \@not_found;
}

sub list_samples_not_db {
    my $uniq_samples = $_[0];

    return $dbi->selectall_arrayref(q{select sample_id from phenotypes join samples on samples.id = phenotypes.sample_id where samples.id not in (} . join(',', @$uniq_samples) . q{)});
}

sub count_uniq_pheno_dbi_samples {
    return $dbi->selectrow_arrayref(q{select count(distinct samples.id) from phenotypes join samples on samples.id = phenotypes.sample_id})->[0];
}

=head1
Counts the amount of RAWS in DB
Counts the amount of files to be uploaded

@param \@files dirlisting of files
=cut
sub test_file_count {
    # count the files
    my $file_count = scalar(@{$_[0]});

    my $raw_count = $dbi->selectrow_arrayref(q{SELECT count(*) FROM `raws`})->[0];
    my $raw_files = $dbi->selectall_hashref(q{SELECT filename FROM `raws`}, 'filename');

    for my $file (@{$_[0]}) {
        if (not exists $raw_files->{ $file }) {
            print "$file\n"
        }
    }

    if ($file_count != $raw_count) {
        ### RAW: $raw_count
        ### FILE:$file_count
    }

    return $file_count == $raw_count;
}

sub count_dbi_plants {
    return $dbi->selectrow_arrayref(q{SELECT count(*) FROM `plants`})->[0];
}

sub count_dbi_samples {
    return $dbi->selectrow_arrayref(q{SELECT count(*) FROM `samples`})->[0];
}

__END__

=head1 SYNOPSIS

    USAGE: test_uploaded_phenotypes.pl

This script will test .. say what?
