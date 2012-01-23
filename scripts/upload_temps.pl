#!/usr/bin/perl

use strict;
use warnings;
use DBI; # resolve the location id
use Getopt::Long;

&run() unless caller();

sub run {
    my ($us_date) = q{};
    
    my $opts = GetOptions(
        'd' => \$us_date
    );

    my $fh = open(F, '<', $ARGV[0]);
    my @lines = <F>;
    close F;

    if (scalar(@lines)) {
        #my $dbi = DBI->connect('dbi:mysql:database=db_billiau_trost;host=hal9000', 'TROST_USER', 'kartoffel');
        #my $dbi = DBI->connect('dbi:mysql:database=trost;host=gent', 'trost', 'passwordpas');
        my $dbi = DBI->connect('dbi:mysql:database=trost_prod;host=gent', 'trost', 'passwordpas');
        #my $dbi = DBI->connect('dbi:mysql:database=trost;host=gent', 'trost', 'passwordpas');

        my $sth = $dbi->prepare('INSERT INTO temps (datum, rainfall, irrigation, tmin, tmax, location_id) VALUES (?, ?, ?, ?, ?, ?)');
        my $location_id = undef;

        my @values = (); # store all VALUES to be inserted afterwards

        LINE:
        for my $line (@lines) {
            next LINE if $line =~ m/\s*#/;
            chomp($line);
            #my ($date, $rainfall, $irrigation, $tmin, $tmax, $limsid) = split /\t/, $line;
            my ($limsid, $date, $tmin, $tmax, $rainfall, $irrigation) = split /\t/, $line;
            if (! $location_id) {
                $location_id = $dbi->selectcol_arrayref('SELECT id FROM locations WHERE limsid = ?', undef, $limsid)->[0];
            }

            # check date
            my ($day, $month, $year) = split /\D/, $date;
            if (length $year == 2) {
                ($day, $year) = ($year, $day);
            }
            if ($us_date) {
                ($day, $month) = ($month, $day);
            }
            $month = $month < 10 ? "0$month" : $month;

            $date = "$year/$month/$day";

            print STDOUT join "\t", ($date, $rainfall, $irrigation, $tmin, $tmax, $location_id);
            print STDOUT "\n";
            push @values, [ $date, $rainfall, $irrigation, $tmin, $tmax, $location_id ];
        }
        print "Do you want to insert these values? \n";
        my $char = 'n';
        sysread STDIN, $char, 1;
        if ($char =~ /^y/i) {
            for my $value (@values) {
                $sth->execute( @$value );
            }
        }
    }
}

__END__

=head1 SYNOPSIS

    USAGE: upload_temps.pl [-d] file.csv

options:
    -d	American style date

The CSV file is to have the columns in the right order: date, rainfall, irrigation, tmin, tmax, location_id

This script will
*  check the date for it's validity in MySQL
*  resolve the location id from LIMS ID to internal ID
