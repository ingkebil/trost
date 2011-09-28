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
    my @files = grep { /[^.]/ } readdir D;
    close D;

    my $counts_of = {}; # { filename => { comp => 0, noncomp => 0 }}

    if (scalar(@files)) {
        $dbi = DBI->connect('dbi:mysql:database=trost;host=localhost', 'trost', 'passwordpas');
        &test_file_count(\@files);
        my $dbi_counts_of = $dbi->selectall_hashref(q{SELECT filename, count(*) as noncomp FROM raws JOIN phenotype_raws ON raw_id = raws.id GROUP BY filename}, 'filename');
        print "FILENAME:\t\t\tDBI\t\t!COMP\t\tBBCH\t\tCOMP\t\tPLANTS\t\tSAMPLES\n";
        for my $file (@files) {
            # next if $file ne 'trost_010611_3.txt';
            my $fh = open(F, '<', $ARGV[0] . $file);
            my @lines = <F>;
            close F;

            $counts_of->{ $file } = {};
            my @comp = grep {/component/} @lines;
            my @bbch = grep {/BBCH/} @lines;
            $counts_of->{ $file }->{ bbch    } = scalar @bbch;
            $counts_of->{ $file }->{ comp    } = scalar @comp;
            $counts_of->{ $file }->{ noncomp } = scalar(@lines) - scalar @comp;
            $counts_of->{ $file }->{ total   } = scalar @lines;
            $counts_of->{ $file }->{ plants  } = {};
            $counts_of->{ $file }->{ samples } = {};
            $counts_of->{ $file }->{ phen_samples } = {};

            # count the plants and samples (as explicitely mentioned in the file)
            if (scalar @comp) {
                for my $line (@comp) {
                    $line =~ m/.*id;(\d+);(\d+);.*/;
                    $counts_of->{ $file }->{ plants  }->{ $2 } = 1;
                    $counts_of->{ $file }->{ samples }->{ $1 } = 1;
                }
            }

            # count samples names in the phenotype (for each phenotype there is a sample)
            my @noncomp = grep { !/component/ } grep { !/BBCH/ } @lines;
            for my $line (@noncomp) {
                my @sample_name = split /;/, $line;
                $counts_of->{ $file }->{ phen_samples }->{ $sample_name[7] } = 1;
            }

            my $dbi_count = defined $dbi_counts_of->{ $file }->{ noncomp } ? $dbi_counts_of->{ $file }->{ noncomp } : 0;
            if ($dbi_count + $counts_of->{ $file }->{ bbch } != $counts_of->{ $file }->{ noncomp }) {
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
        print "# uniq plants = # DBI plants (-1 placeholder)\n";
        print &count_uniq_plants($counts_of);
        print ' = ';
        print &count_dbi_plants(), " - 1\n";
        print "# uniq phen samples = # DBI phen samples\n";
        print &count_uniq_pheno_samples($counts_of);
        print ' = ';
        print &count_uniq_pheno_dbi_samples(), "\n";
        print "# DBI samples = # uniq phen samples + # unconnected samples\n";
        print &count_dbi_samples();
        print ' = ';
        print &count_uniq_pheno_samples($counts_of);
        print ' + ';
        print &count_unconnected_samples(), "\n";
        print "# samples = # uniq samples\n";
        print &count_samples($counts_of);
        print ' = ';
        print &count_uniq_samples($counts_of);

        print "\n\n\n\n";
        print Dumper &list_samples_not_db(&list_uniq_pheno_samples($counts_of));
    }
}

sub count_unconnected_samples {
    return $dbi->selectrow_arrayref(q{SELECT count(*) from samples left join phenotypes on samples.id = phenotypes.sample_id where phenotypes.id is null;})->[0];
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
    }

    my @uniq_samples = keys %$uniq;
    return \@uniq_samples;
}

sub list_samples_not_db {
    my $uniq_samples = $_[0];

    return $dbi->selectall_arrayref(q{select sample_id from phenotypes join samples on samples.id = phenotypes.sample_id where samples.name not in (} . join(',', @$uniq_samples) . q{)});
}

sub count_uniq_pheno_dbi_samples {
    return $dbi->selectrow_arrayref(q{select count(distinct samples.name) from phenotypes join samples on samples.id = phenotypes.sample_id})->[0];
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

This script will test
