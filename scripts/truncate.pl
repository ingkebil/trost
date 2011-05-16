#!/usr/bin/perl

use strict;
use warnings;

sub usage {
    die "USAGE: $0 username password [dbname [host]]\n";
}

my $user = $ARGV[0] || &usage;
my $pass = $ARGV[1] || &usage;
my $db   = $ARGV[2] || 'trost';
my $host = $ARGV[2] || 'localhost';

`echo 'TRUNCATE phenotype_bbches;'   | mysql -u $user -p$pass -h $host $db`;
`echo 'TRUNCATE phenotype_entities;' | mysql -u $user -p$pass -h $host $db`;
`echo 'TRUNCATE phenotype_raws;'     | mysql -u $user -p$pass -h $host $db`;
`echo 'TRUNCATE phenotype_values;'   | mysql -u $user -p$pass -h $host $db`;
`echo 'TRUNCATE raws;'               | mysql -u $user -p$pass -h $host $db`;
`echo 'TRUNCATE temps;'              | mysql -u $user -p$pass -h $host $db`;
`echo 'TRUNCATE phenotypes;'         | mysql -u $user -p$pass -h $host $db`;
`echo 'TRUNCATE plants;'             | mysql -u $user -p$pass -h $host $db`;
