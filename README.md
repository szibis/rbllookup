RBLLookup
=========

Simple PHP script for ip/domain RBL lookup. If you need simple script to run check on your mailserver domain for example every 24h.

### Requirements

* PHP
* SendEmail (for sending email reports - check.sh.example)

### How to use

```bash
php rbllookup.php example.com
Checking 93.184.216.119 (93.184.216.119) in Domain: 34 list's, IP: 269 list's ->
93.184.216.119 (93.184.216.119) [Listed] [DomainBL] -> (93.184.216.119.dbl.spamhaus.org 93.184.216.119.black.uribl.com 93.184.216.119.grey.uribl.com 93.184.216.119.multi.uribl.com 93.184.216.119.red.uribl.com )
```
