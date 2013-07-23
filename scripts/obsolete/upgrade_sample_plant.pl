#!/usr/bin/perl

use strict;
use warnings;

sub usage {
    warn "USAGE: perl $0 username pass db [host]\n";
    warn "db param is the DB to alter!\n";
    warn "Afterwards one still needs to reinstantiate the temp-part of the DB!\n";
}
my $user = $ARGV[0] || &usage;
my $pass = $ARGV[1] || &usage;
my $db   = $ARGV[2] || &usage;
my $host = $ARGV[3] || 'localhost';

`echo 'DROP TABLE phenotypes;' | mysql -u $user -p$pass -h $host $db`;
`echo 'DROP TABLE plants;' | mysql -u $user -p$pass -h $host $db`;
`echo 'DROP TABLE samples;' | mysql -u $user -p$pass -h $host $db`;
`echo 'DROP TABLE cultures;' | mysql -u $user -p$pass -h $host $db`;
`echo 'DROP TABLE experiments;' | mysql -u $user -p$pass -h $host $db`;
`echo 'DROP TABLE phenotype_entities;' | mysql -u $user -p$pass -h $host $db`;
`echo 'DROP TABLE phenotype_values;' | mysql -u $user -p$pass -h $host $db`;
`echo 'DROP TABLE phenotype_bbches;' | mysql -u $user -p$pass -h $host $db`;
`echo 'DROP TABLE phenotype_raws;' | mysql -u $user -p$pass -h $host $db`;
`echo 'DROP TABLE raws;' | mysql -u $user -p$pass -h $host $db`;
