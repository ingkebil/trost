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
        print "FILENAME:\t\t\tDBI\t\t!COMP\t\tBBCH\n";
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

            my $dbi_count = defined $dbi_counts_of->{ $file }->{ noncomp } ? $dbi_counts_of->{ $file }->{ noncomp } : 0;
            if ($dbi_count + $counts_of->{ $file }->{ bbch } != $counts_of->{ $file }->{ noncomp }) {
                print '*';
            }
            print "$file:\t\t$dbi_count\t\t$counts_of->{ $file }->{ noncomp }\t\t$counts_of->{ $file }->{ bbch }\n";
        }
    }
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

__END__

=head1 SYNOPSIS

    USAGE: test_uploaded_phenotypes.pl

This script will test
