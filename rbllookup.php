<?php
function dnsbllookup($ip, $debug){

# include rbl lists
include rbls_include;

if($ip){
$ilisted = "";
$dlisted = "";
$status = 0;
$ipsize = sizeof($iptable);
$domsize = sizeof($domaintable);
$hostname = gethostbyaddr($ip);

print "Checking $hostname ($ip) in Domain: $domsize list's, IP: $ipsize list's -> ";
if($debug){
print "\n";
}
$reverse_ip=implode(".",array_reverse(explode(".",$ip)));
        foreach($domaintable as $dhost){
                $starttime = microtime(true);
                if(checkdnsrr($hostname.".".$dhost.".","A")){
                        $dlisted.=$hostname.'.'.$dhost.' ';
                        if ($debug){
                                if ($dlisted){
                                        print "[Listed] ";
                                }
                        }
                }else{
                        if($debug){
                                print "[NotListed] ";
                        }
                }
                $stoptime = microtime(true);
                $dstatus = ($stoptime - $starttime) * 1000;
                $dstatus = floor($dstatus);
                if($debug){
                        print "DomainBL: $dhost, Time: $dstatus" . "[ms]\n";
                }
        }
        foreach($iptable as $ihost){
                $starttime = microtime(true);
                if(checkdnsrr($reverse_ip.".".$ihost.".","A")){
                        $ilisted.=$reverse_ip.'.'.$ihost.' ';
                        if ($debug){
                                if ($ilisted){
                                        print "[Listed] ";
                                }
                        }
                }else{
                        if ($debug){
                                print "[NotListed] ";
                        }
                }
                $stoptime = microtime(true);
                $istatus = ($stoptime - $starttime) * 1000;
                $istatus = floor($istatus);
                if($debug){
                        print "IPBL: $ihost, Time: $istatus" . "[ms]\n";
                }
        }
        $domfile = "/tmp/listed";
        $listout = file_get_contents($domfile);
        $listout = "Check - Domain: $domsize list's, IP: $ipsize list's: \n";
        file_put_contents($domfile, $listout, FILE_APPEND);
if($dlisted){
        $domfile = "/tmp/listed";
        $listout = file_get_contents($domfile);
        $listout = "$hostname ($ip) [Listed] [DomainBL] -> ($dlisted) \n";
        file_put_contents($domfile, $listout, FILE_APPEND);
        print $listout;
}elseif($ilisted){
        $domfile = "/tmp/listed";
        $listout = file_get_contents($domfile);
        $listout = "$hostname ($ip) [Listed] [IPBL] -> ($ilisted) \n";
        file_put_contents($domfile, $listout, FILE_APPEND);
        print $listout;
}else{
        $domfile = "/tmp/listed";
        $clean = file_get_contents($domfile);
        $clean = '$hostname ($ip) [Clean] \n';
        file_put_contents($domfile, $clean, FILE_APPEND);
        print $clean;
}
}
}

if (!$argv[2]){
  $debug = 0;
}else {
$debug = $argv[2];
}
$domain = $argv[1];
$ip = gethostbyname($domain);
#$ip = $argv[1];

$startfulltime = microtime(true);
if(isset($ip) && $ip!=null){
if(filter_var($ip,FILTER_VALIDATE_IP)){
        echo dnsbllookup($ip, $debug);

}else{
        echo "Please enter a valid IP";
}
}
$stopfulltime = microtime(true);
$statusfull = ($stopfulltime - $startfulltime) * 1000;
$statusfull = floor($statusfull);
if($debug){
        print "Summary time: $statusfull" . "[ms]";
}
?>
