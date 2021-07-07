<?php

/* -*- Mode: C; indent-tabs-mode: t; c-basic-offset: 2; tab-width: 2 -*- */
/* geoip.inc
 *
 * Copyright (C) 2007 MaxMind LLC
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

define("GEOIP_COUNTRY_BEGIN", 16776960);
define("GEOIP_STATE_BEGIN_REV0", 16700000);
define("GEOIP_STATE_BEGIN_REV1", 16000000);
define("GEOIP_STANDARD", 0);
define("GEOIP_MEMORY_CACHE", 1);
define("GEOIP_SHARED_MEMORY", 2);
define("STRUCTURE_INFO_MAX_SIZE", 20);
define("DATABASE_INFO_MAX_SIZE", 100);
define("GEOIP_COUNTRY_EDITION", 106);
define("GEOIP_PROXY_EDITION", 8);
define("GEOIP_ASNUM_EDITION", 9);
define("GEOIP_NETSPEED_EDITION", 10);
define("GEOIP_REGION_EDITION_REV0", 112);
define("GEOIP_REGION_EDITION_REV1", 3);
define("GEOIP_CITY_EDITION_REV0", 111);
define("GEOIP_CITY_EDITION_REV1", 2);
define("GEOIP_ORG_EDITION", 110);
define("GEOIP_ISP_EDITION", 4);
define("SEGMENT_RECORD_LENGTH", 3);
define("STANDARD_RECORD_LENGTH", 3);
define("ORG_RECORD_LENGTH", 4);
define("MAX_RECORD_LENGTH", 4);
define("MAX_ORG_RECORD_LENGTH", 300);
define("GEOIP_SHM_KEY", 0x4f415401);
define("US_OFFSET", 1);
define("CANADA_OFFSET", 677);
define("WORLD_OFFSET", 1353);
define("FIPS_RANGE", 360);
define("GEOIP_UNKNOWN_SPEED", 0);
define("GEOIP_DIALUP_SPEED", 1);
define("GEOIP_CABLEDSL_SPEED", 2);
define("GEOIP_CORPORATE_SPEED", 3);

class GeoIP {
    var $flags;
    var $filehandle;
    var $memory_buffer;
    var $databaseType;
    var $databaseSegments;
    var $record_length;
    var $shmid;
    var $GEOIP_COUNTRY_CODE_TO_NUMBER = array(
"" => 0, "ap" => 1, "eu" => 2, "ad" => 3, "ae" => 4, "af" => 5, 
"ag" => 6, "ai" => 7, "al" => 8, "am" => 9, "an" => 10, "ao" => 11, 
"aq" => 12, "ar" => 13, "as" => 14, "at" => 15, "au" => 16, "aw" => 17, 
"az" => 18, "ba" => 19, "bb" => 20, "bd" => 21, "be" => 22, "bf" => 23, 
"bg" => 24, "bh" => 25, "bi" => 26, "bj" => 27, "bm" => 28, "bn" => 29, 
"bo" => 30, "br" => 31, "bs" => 32, "bt" => 33, "bv" => 34, "bw" => 35, 
"by" => 36, "bz" => 37, "ca" => 38, "cc" => 39, "cd" => 40, "cf" => 41, 
"cg" => 42, "ch" => 43, "ci" => 44, "ck" => 45, "cl" => 46, "cm" => 47, 
"cn" => 48, "co" => 49, "cr" => 50, "cu" => 51, "cv" => 52, "cx" => 53, 
"cy" => 54, "cz" => 55, "de" => 56, "dj" => 57, "dk" => 58, "dm" => 59, 
"do" => 60, "dz" => 61, "ec" => 62, "ee" => 63, "eg" => 64, "eh" => 65, 
"er" => 66, "es" => 67, "et" => 68, "fi" => 69, "fj" => 70, "fk" => 71, 
"fm" => 72, "fo" => 73, "fr" => 74, "fx" => 75, "ga" => 76, "gb" => 77,
"gd" => 78, "ge" => 79, "gf" => 80, "gh" => 81, "gi" => 82, "gl" => 83, 
"gm" => 84, "gn" => 85, "gp" => 86, "gq" => 87, "gr" => 88, "gs" => 89, 
"gt" => 90, "gu" => 91, "gw" => 92, "gy" => 93, "hk" => 94, "hm" => 95, 
"hn" => 96, "hr" => 97, "ht" => 98, "hu" => 99, "id" => 100, "ie" => 101, 
"il" => 102, "in" => 103, "io" => 104, "iq" => 105, "ir" => 106, "is" => 107, 
"it" => 108, "jm" => 109, "jo" => 110, "jp" => 111, "ke" => 112, "kg" => 113, 
"kh" => 114, "ki" => 115, "km" => 116, "kn" => 117, "kp" => 118, "kr" => 119, 
"kw" => 120, "ky" => 121, "kz" => 122, "la" => 123, "lb" => 124, "lc" => 125, 
"li" => 126, "lk" => 127, "lr" => 128, "ls" => 129, "lt" => 130, "lu" => 131, 
"lv" => 132, "ly" => 133, "ma" => 134, "mc" => 135, "md" => 136, "mg" => 137, 
"mh" => 138, "mk" => 139, "ml" => 140, "mm" => 141, "mn" => 142, "mo" => 143, 
"mp" => 144, "mq" => 145, "mr" => 146, "ms" => 147, "mt" => 148, "mu" => 149, 
"mv" => 150, "mw" => 151, "mx" => 152, "my" => 153, "mz" => 154, "na" => 155,
"nc" => 156, "ne" => 157, "nf" => 158, "ng" => 159, "ni" => 160, "nl" => 161, 
"no" => 162, "np" => 163, "nr" => 164, "nu" => 165, "nz" => 166, "om" => 167, 
"pa" => 168, "pe" => 169, "pf" => 170, "pg" => 171, "ph" => 172, "pk" => 173, 
"pl" => 174, "pm" => 175, "pn" => 176, "pr" => 177, "ps" => 178, "pt" => 179, 
"pw" => 180, "py" => 181, "qa" => 182, "re" => 183, "ro" => 184, "ru" => 185, 
"rw" => 186, "sa" => 187, "sb" => 188, "sc" => 189, "sd" => 190, "se" => 191, 
"sg" => 192, "sh" => 193, "si" => 194, "sj" => 195, "sk" => 196, "sl" => 197, 
"sm" => 198, "sn" => 199, "so" => 200, "sr" => 201, "st" => 202, "sv" => 203, 
"sy" => 204, "sz" => 205, "tc" => 206, "td" => 207, "tf" => 208, "tg" => 209, 
"th" => 210, "tj" => 211, "tk" => 212, "tm" => 213, "tn" => 214, "to" => 215, 
"tl" => 216, "tr" => 217, "tt" => 218, "tv" => 219, "tw" => 220, "tz" => 221, 
"ua" => 222, "ug" => 223, "um" => 224, "us" => 225, "uy" => 226, "uz" => 227, 
"va" => 228, "vc" => 229, "ve" => 230, "vg" => 231, "vi" => 232, "vn" => 233,
"vu" => 234, "wf" => 235, "ws" => 236, "ye" => 237, "yt" => 238, "rs" => 239, 
"za" => 240, "zm" => 241, "me" => 242, "zw" => 243, "a1" => 244, "a2" => 245, 
"o1" => 246, "ax" => 247, "gg" => 248, "im" => 249, "je" => 250, "bl" => 251,
"mf" => 252
);
    var $GEOIP_COUNTRY_CODES = array(
"", "ap", "eu", "ad", "ae", "af", "ag", "ai", "al", "am", "an", "ao", "aq",
"ar", "as", "at", "au", "aw", "az", "ba", "bb", "bd", "be", "bf", "bg", "bh",
"bi", "bj", "bm", "bn", "bo", "br", "bs", "bt", "bv", "bw", "by", "bz", "ca",
"cc", "cd", "cf", "cg", "ch", "ci", "ck", "cl", "cm", "cn", "co", "cr", "cu",
"cv", "cx", "cy", "cz", "de", "dj", "dk", "dm", "do", "dz", "ec", "ee", "eg",
"eh", "er", "es", "et", "fi", "fj", "fk", "fm", "fo", "fr", "fx", "ga", "gb",
"gd", "ge", "gf", "gh", "gi", "gl", "gm", "gn", "gp", "gq", "gr", "gs", "gt",
"gu", "gw", "gy", "hk", "hm", "hn", "hr", "ht", "hu", "id", "ie", "il", "in",
"io", "iq", "ir", "is", "it", "jm", "jo", "jp", "ke", "kg", "kh", "ki", "km",
"kn", "kp", "kr", "kw", "ky", "kz", "la", "lb", "lc", "li", "lk", "lr", "ls",
"lt", "lu", "lv", "ly", "ma", "mc", "md", "mg", "mh", "mk", "ml", "mm", "mn",
"mo", "mp", "mq", "mr", "ms", "mt", "mu", "mv", "mw", "mx", "my", "mz", "na",
"nc", "ne", "nf", "ng", "ni", "nl", "no", "np", "nr", "nu", "nz", "om", "pa",
"pe", "pf", "pg", "ph", "pk", "pl", "pm", "pn", "pr", "ps", "pt", "pw", "py",
"qa", "re", "ro", "ru", "rw", "sa", "sb", "sc", "sd", "se", "sg", "sh", "si",
"sj", "sk", "sl", "sm", "sn", "so", "sr", "st", "sv", "sy", "sz", "tc", "td",
"tf", "tg", "th", "tj", "tk", "tm", "tn", "to", "tl", "tr", "tt", "tv", "tw",
"tz", "ua", "ug", "um", "us", "uy", "uz", "va", "vc", "ve", "vg", "vi", "vn",
"vu", "wf", "ws", "ye", "yt", "rs", "za", "zm", "me", "zw", "a1", "a2", "o1",
"ax", "gg", "im", "je", "bl", "mf"
);
    var $GEOIP_COUNTRY_CODES3 = array(
"","ap","eu","and","are","afg","atg","aia","alb","arm","ant","ago","aq","arg",
"asm","aut","aus","abw","aze","bih","brb","bgd","bel","bfa","bgr","bhr","bdi",
"ben","bmu","brn","bol","bra","bhs","btn","bv","bwa","blr","blz","can","cc",
"cod","caf","cog","che","civ","cok","chl","cmr","chn","col","cri","cub","cpv",
"cx","cyp","cze","deu","dji","dnk","dma","dom","dza","ecu","est","egy","esh",
"eri","esp","eth","fin","fji","flk","fsm","fro","fra","fx","gab","gbr","grd",
"geo","guf","gha","gib","grl","gmb","gin","glp","gnq","grc","gs","gtm","gum",
"gnb","guy","hkg","hm","hnd","hrv","hti","hun","idn","irl","isr","ind","io",
"irq","irn","isl","ita","jam","jor","jpn","ken","kgz","khm","kir","com","kna",
"prk","kor","kwt","cym","kaz","lao","lbn","lca","lie","lka","lbr","lso","ltu",
"lux","lva","lby","mar","mco","mda","mdg","mhl","mkd","mli","mmr","mng","mac",
"mnp","mtq","mrt","msr","mlt","mus","mdv","mwi","mex","mys","moz","nam","ncl",
"ner","nfk","nga","nic","nld","nor","npl","nru","niu","nzl","omn","pan","per",
"pyf","png","phl","pak","pol","spm","pcn","pri","pse","prt","plw","pry","qat",
"reu","rou","rus","rwa","sau","slb","syc","sdn","swe","sgp","shn","svn","sjm",
"svk","sle","smr","sen","som","sur","stp","slv","syr","swz","tca","tcd","tf",
"tgo","tha","tjk","tkl","tls","tkm","tun","ton","tur","tto","tuv","twn","tza",
"ukr","uga","um","usa","ury","uzb","vat","vct","ven","vgb","vir","vnm","vut",
"wlf","wsm","yem","yt","srb","zaf","zmb","mne","zwe","a1","a2","o1",
"ala","ggy","imn","jey","blm","maf"
    );
    var $GEOIP_COUNTRY_NAMES = array(
"", "Asia/Pacific Region", "Europe", "Andorra", "United Arab Emirates",
"Afghanistan", "Antigua and Barbuda", "Anguilla", "Albania", "Armenia",
"Netherlands Antilles", "Angola", "Antarctica", "Argentina", "American Samoa",
"Austria", "Australia", "Aruba", "Azerbaijan", "Bosnia and Herzegovina",
"Barbados", "Bangladesh", "Belgium", "Burkina Faso", "Bulgaria", "Bahrain",
"Burundi", "Benin", "Bermuda", "Brunei Darussalam", "Bolivia", "Brazil",
"Bahamas", "Bhutan", "Bouvet Island", "Botswana", "Belarus", "Belize",
"Canada", "Cocos (Keeling) Islands", "Congo, The Democratic Republic of the",
"Central African Republic", "Congo", "Switzerland", "Cote D'Ivoire", "Cook Islands",
"Chile", "Cameroon", "China", "Colombia", "Costa Rica", "Cuba", "Cape Verde",
"Christmas Island", "Cyprus", "Czech Republic", "Germany", "Djibouti",
"Denmark", "Dominica", "Dominican Republic", "Algeria", "Ecuador", "Estonia",
"Egypt", "Western Sahara", "Eritrea", "Spain", "Ethiopia", "Finland", "Fiji",
"Falkland Islands (Malvinas)", "Micronesia, Federated States of", "Faroe Islands",
"France", "France, Metropolitan", "Gabon", "United Kingdom",
"Grenada", "Georgia", "French Guiana", "Ghana", "Gibraltar", "Greenland",
"Gambia", "Guinea", "Guadeloupe", "Equatorial Guinea", "Greece", "South Georgia and the South Sandwich Islands",
"Guatemala", "Guam", "Guinea-Bissau",
"Guyana", "Hong Kong", "Heard Island and McDonald Islands", "Honduras",
"Croatia", "Haiti", "Hungary", "Indonesia", "Ireland", "Israel", "India",
"British Indian Ocean Territory", "Iraq", "Iran, Islamic Republic of",
"Iceland", "Italy", "Jamaica", "Jordan", "Japan", "Kenya", "Kyrgyzstan",
"Cambodia", "Kiribati", "Comoros", "Saint Kitts and Nevis", "Korea, Democratic People's Republic of",
"Korea, Republic of", "Kuwait", "Cayman Islands",
"Kazakhstan", "Lao People's Democratic Republic", "Lebanon", "Saint Lucia",
"Liechtenstein", "Sri Lanka", "Liberia", "Lesotho", "Lithuania", "Luxembourg",
"Latvia", "Libyan Arab Jamahiriya", "Morocco", "Monaco", "Moldova, Republic of",
"Madagascar", "Marshall Islands", "Macedonia",
"Mali", "Myanmar", "Mongolia", "Macau", "Northern Mariana Islands",
"Martinique", "Mauritania", "Montserrat", "Malta", "Mauritius", "Maldives",
"Malawi", "Mexico", "Malaysia", "Mozambique", "Namibia", "New Caledonia",
"Niger", "Norfolk Island", "Nigeria", "Nicaragua", "Netherlands", "Norway",
"Nepal", "Nauru", "Niue", "New Zealand", "Oman", "Panama", "Peru", "French Polynesia",
"Papua New Guinea", "Philippines", "Pakistan", "Poland", "Saint Pierre and Miquelon",
"Pitcairn Islands", "Puerto Rico", "Palestinian Territory",
"Portugal", "Palau", "Paraguay", "Qatar", "Reunion", "Romania",
"Russian Federation", "Rwanda", "Saudi Arabia", "Solomon Islands",
"Seychelles", "Sudan", "Sweden", "Singapore", "Saint Helena", "Slovenia",
"Svalbard and Jan Mayen", "Slovakia", "Sierra Leone", "San Marino", "Senegal",
"Somalia", "Suriname", "Sao Tome and Principe", "El Salvador", "Syrian Arab Republic",
"Swaziland", "Turks and Caicos Islands", "Chad", "French Southern Territories",
"Togo", "Thailand", "Tajikistan", "Tokelau", "Turkmenistan",
"Tunisia", "Tonga", "Timor-Leste", "Turkey", "Trinidad and Tobago", "Tuvalu",
"Taiwan", "Tanzania, United Republic of", "Ukraine",
"Uganda", "United States Minor Outlying Islands", "United States", "Uruguay",
"Uzbekistan", "Holy See (Vatican City State)", "Saint Vincent and the Grenadines",
"Venezuela", "Virgin Islands, British", "Virgin Islands, U.S.",
"Vietnam", "Vanuatu", "Wallis and Futuna", "Samoa", "Yemen", "Mayotte",
"Serbia", "South Africa", "Zambia", "Montenegro", "Zimbabwe",
"Anonymous Proxy","Satellite Provider","Other",
"Aland Islands","Guernsey","Isle of Man","Jersey","Saint Barthelemy","Saint Martin"
);

    var $GEOIP_CONTINENT_CODES = array(
"--", "AS", "EU", "EU", "AS", "AS", "SA", "SA", "EU", "AS",
"SA", "AF", "AN", "SA", "OC", "EU", "OC", "SA", "AS", "EU",
"SA", "AS", "EU", "AF", "EU", "AS", "AF", "AF", "SA", "AS",
"SA", "SA", "SA", "AS", "AF", "AF", "EU", "SA", "NA", "AS",
"AF", "AF", "AF", "EU", "AF", "OC", "SA", "AF", "AS", "SA",
"SA", "SA", "AF", "AS", "AS", "EU", "EU", "AF", "EU", "SA",
"SA", "AF", "SA", "EU", "AF", "AF", "AF", "EU", "AF", "EU",
"OC", "SA", "OC", "EU", "EU", "EU", "AF", "EU", "SA", "AS",
"SA", "AF", "EU", "SA", "AF", "AF", "SA", "AF", "EU", "SA",
"SA", "OC", "AF", "SA", "AS", "AF", "SA", "EU", "SA", "EU",
"AS", "EU", "AS", "AS", "AS", "AS", "AS", "EU", "EU", "SA",
"AS", "AS", "AF", "AS", "AS", "OC", "AF", "SA", "AS", "AS",
"AS", "SA", "AS", "AS", "AS", "SA", "EU", "AS", "AF", "AF",
"EU", "EU", "EU", "AF", "AF", "EU", "EU", "AF", "OC", "EU",
"AF", "AS", "AS", "AS", "OC", "SA", "AF", "SA", "EU", "AF",
"AS", "AF", "NA", "AS", "AF", "AF", "OC", "AF", "OC", "AF",
"SA", "EU", "EU", "AS", "OC", "OC", "OC", "AS", "SA", "SA",
"OC", "OC", "AS", "AS", "EU", "SA", "OC", "SA", "AS", "EU",
"OC", "SA", "AS", "AF", "EU", "AS", "AF", "AS", "OC", "AF",
"AF", "EU", "AS", "AF", "EU", "EU", "EU", "AF", "EU", "AF",
"AF", "SA", "AF", "SA", "AS", "AF", "SA", "AF", "AF", "AF",
"AS", "AS", "OC", "AS", "AF", "OC", "AS", "EU", "SA", "OC",
"AS", "AF", "EU", "AF", "OC", "NA", "SA", "AS", "EU", "SA",
"SA", "SA", "SA", "AS", "OC", "OC", "OC", "AS", "AF", "EU",
"AF", "AF", "EU", "AF", "--", "--", "--", "EU", "EU", "EU",
"EU", "SA", "SA" );
    
}
function geoip_load_shared_mem ($file) {

  $fp = fopen($file, "rb");
  if (!$fp) {
    print "error opening $file: $php_errormsg\n";
    exit;
  }
  $s_array = fstat($fp);
  $size = $s_array['size'];
  if ($shmid = @shmop_open (GEOIP_SHM_KEY, "w", 0, 0)) {
    shmop_delete ($shmid);
    shmop_close ($shmid);
  }
  $shmid = shmop_open (GEOIP_SHM_KEY, "c", 0644, $size);
  shmop_write ($shmid, fread($fp, $size), 0);
  shmop_close ($shmid);
}

function _setup_segments($gi){
  $gi->databaseType = GEOIP_COUNTRY_EDITION;
  $gi->record_length = STANDARD_RECORD_LENGTH;
  if ($gi->flags & GEOIP_SHARED_MEMORY) {
    $offset = @shmop_size ($gi->shmid) - 3;
    for ($i = 0; $i < STRUCTURE_INFO_MAX_SIZE; $i++) {
        $delim = @shmop_read ($gi->shmid, $offset, 3);
        $offset += 3;
        if ($delim == (chr(255).chr(255).chr(255))) {
            $gi->databaseType = ord(@shmop_read ($gi->shmid, $offset, 1));
            $offset++;

            if ($gi->databaseType == GEOIP_REGION_EDITION_REV0){
                $gi->databaseSegments = GEOIP_STATE_BEGIN_REV0;
            } else if ($gi->databaseType == GEOIP_REGION_EDITION_REV1){
                $gi->databaseSegments = GEOIP_STATE_BEGIN_REV1;
	    } else if (($gi->databaseType == GEOIP_CITY_EDITION_REV0)||
                     ($gi->databaseType == GEOIP_CITY_EDITION_REV1) 
                    || ($gi->databaseType == GEOIP_ORG_EDITION)
		    || ($gi->databaseType == GEOIP_ISP_EDITION)
		    || ($gi->databaseType == GEOIP_ASNUM_EDITION)){
                $gi->databaseSegments = 0;
                $buf = @shmop_read ($gi->shmid, $offset, SEGMENT_RECORD_LENGTH);
                for ($j = 0;$j < SEGMENT_RECORD_LENGTH;$j++){
                    $gi->databaseSegments += (ord($buf[$j]) << ($j * 8));
                }
	            if (($gi->databaseType == GEOIP_ORG_EDITION)||
			($gi->databaseType == GEOIP_ISP_EDITION)) {
	                $gi->record_length = ORG_RECORD_LENGTH;
                }
            }
            break;
        } else {
            $offset -= 4;
        }
    }
    if (($gi->databaseType == GEOIP_COUNTRY_EDITION)||
        ($gi->databaseType == GEOIP_PROXY_EDITION)||
        ($gi->databaseType == GEOIP_NETSPEED_EDITION)){
        $gi->databaseSegments = GEOIP_COUNTRY_BEGIN;
    }
  } else {
    $filepos = ftell($gi->filehandle);
    fseek($gi->filehandle, -3, SEEK_END);
    for ($i = 0; $i < STRUCTURE_INFO_MAX_SIZE; $i++) {
        $delim = fread($gi->filehandle,3);
        if ($delim == (chr(255).chr(255).chr(255))){
        $gi->databaseType = ord(fread($gi->filehandle,1));
        if ($gi->databaseType == GEOIP_REGION_EDITION_REV0){
            $gi->databaseSegments = GEOIP_STATE_BEGIN_REV0;
        }
        else if ($gi->databaseType == GEOIP_REGION_EDITION_REV1){
	    $gi->databaseSegments = GEOIP_STATE_BEGIN_REV1;
                }  else if (($gi->databaseType == GEOIP_CITY_EDITION_REV0) ||
                 ($gi->databaseType == GEOIP_CITY_EDITION_REV1) || 
                 ($gi->databaseType == GEOIP_ORG_EDITION) || 
		 ($gi->databaseType == GEOIP_ISP_EDITION) || 
                 ($gi->databaseType == GEOIP_ASNUM_EDITION)){
            $gi->databaseSegments = 0;
            $buf = fread($gi->filehandle,SEGMENT_RECORD_LENGTH);
            for ($j = 0;$j < SEGMENT_RECORD_LENGTH;$j++){
            $gi->databaseSegments += (ord($buf[$j]) << ($j * 8));
            }
	    if ($gi->databaseType == GEOIP_ORG_EDITION ||
		$gi->databaseType == GEOIP_ISP_EDITION) {
	    $gi->record_length = ORG_RECORD_LENGTH;
            }
        }
        break;
        } else {
        fseek($gi->filehandle, -4, SEEK_CUR);
        }
    }
    if (($gi->databaseType == GEOIP_COUNTRY_EDITION)||
        ($gi->databaseType == GEOIP_PROXY_EDITION)||
        ($gi->databaseType == GEOIP_NETSPEED_EDITION)){
         $gi->databaseSegments = GEOIP_COUNTRY_BEGIN;
    }
    fseek($gi->filehandle,$filepos,SEEK_SET);
  }
  return $gi;
}

function geoip_open($filename, $flags) {
  $gi = new GeoIP;
  $gi->flags = $flags;
  if ($gi->flags & GEOIP_SHARED_MEMORY) {
    $gi->shmid = @shmop_open (GEOIP_SHM_KEY, "a", 0, 0);
    } else {
    $gi->filehandle = fopen($filename,"rb") or die( "Can not open $filename\n" );
    if ($gi->flags & GEOIP_MEMORY_CACHE) {
        $s_array = fstat($gi->filehandle);
        $gi->memory_buffer = fread($gi->filehandle, $s_array['size']);
    }
  }

  $gi = _setup_segments($gi);
  return $gi;
}

function geoip_close($gi) {
  if ($gi->flags & GEOIP_SHARED_MEMORY) {
    return true;
  }

  return fclose($gi->filehandle);
}

function geoip_country_id_by_name($gi, $name) {
  $addr = gethostbyname($name);
  if (!$addr || $addr == $name) {
    return false;
  }
  return geoip_country_id_by_addr($gi, $addr);
}

function geoip_country_code_by_name($gi, $name) {
  $country_id = geoip_country_id_by_name($gi,$name);
  if ($country_id !== false) {
        return $gi->GEOIP_COUNTRY_CODES[$country_id];
  }
  return false;
}

function geoip_country_name_by_name($gi, $name) {
  $country_id = geoip_country_id_by_name($gi,$name);
  if ($country_id !== false) {
        return $gi->GEOIP_COUNTRY_NAMES[$country_id];
  }
  return false;
}

function geoip_country_id_by_addr($gi, $addr) {
  $ipnum = ip2long($addr);
  return _geoip_seek_country($gi, $ipnum) - GEOIP_COUNTRY_BEGIN;
}

function geoip_country_code_by_addr($gi, $addr) {
  if ($gi->databaseType == GEOIP_CITY_EDITION_REV1) {
    $record = geoip_record_by_addr($gi,$addr);
    if ( $record !== false ) {
      return $record->country_code;
    }
  } else {
    $country_id = geoip_country_id_by_addr($gi,$addr);
    if ($country_id !== false) {
      return $gi->GEOIP_COUNTRY_CODES[$country_id];
    }
  }
  return false;
}

function geoip_country_name_by_addr($gi, $addr) {
  if ($gi->databaseType == GEOIP_CITY_EDITION_REV1) {
    $record = geoip_record_by_addr($gi,$addr);
    return $record->country_name;
  } else {
    $country_id = geoip_country_id_by_addr($gi,$addr);
    if ($country_id !== false) {
      return $gi->GEOIP_COUNTRY_NAMES[$country_id];
    }
  }
  return false;
}

function _geoip_seek_country($gi, $ipnum) {
  $offset = 0;
  for ($depth = 31; $depth >= 0; --$depth) {
    if ($gi->flags & GEOIP_MEMORY_CACHE) {
      // workaround php's broken substr, strpos, etc handling with
      // mbstring.func_overload and mbstring.internal_encoding
      $enc = mb_internal_encoding();
       mb_internal_encoding('ISO-8859-1'); 

      $buf = substr($gi->memory_buffer,
                            2 * $gi->record_length * $offset,
                            2 * $gi->record_length);

      mb_internal_encoding($enc);
    } elseif ($gi->flags & GEOIP_SHARED_MEMORY) {
      $buf = @shmop_read ($gi->shmid, 
                            2 * $gi->record_length * $offset,
                            2 * $gi->record_length );
        } else {
      fseek($gi->filehandle, 2 * $gi->record_length * $offset, SEEK_SET) == 0
        or die("fseek failed");
      $buf = fread($gi->filehandle, 2 * $gi->record_length);
    }
    $x = array(0,0);
    for ($i = 0; $i < 2; ++$i) {
      for ($j = 0; $j < $gi->record_length; ++$j) {
        $x[$i] += ord($buf[$gi->record_length * $i + $j]) << ($j * 8);
      }
    }
    if ($ipnum & (1 << $depth)) {
      if ($x[1] >= $gi->databaseSegments) {
        return $x[1];
      }
      $offset = $x[1];
        } else {
      if ($x[0] >= $gi->databaseSegments) {
        return $x[0];
      }
      $offset = $x[0];
    }
  }
  trigger_error("error traversing database - perhaps it is corrupt?", E_USER_ERROR);
  return false;
}

function _get_org($gi,$ipnum){
  $seek_org = _geoip_seek_country($gi,$ipnum);
  if ($seek_org == $gi->databaseSegments) {
    return NULL;
  }
  $record_pointer = $seek_org + (2 * $gi->record_length - 1) * $gi->databaseSegments;
  if ($gi->flags & GEOIP_SHARED_MEMORY) {
    $org_buf = @shmop_read ($gi->shmid, $record_pointer, MAX_ORG_RECORD_LENGTH);
    } else {
    fseek($gi->filehandle, $record_pointer, SEEK_SET);
    $org_buf = fread($gi->filehandle,MAX_ORG_RECORD_LENGTH);
  }
  // workaround php's broken substr, strpos, etc handling with
  // mbstring.func_overload and mbstring.internal_encoding
  $enc = mb_internal_encoding();
  mb_internal_encoding('ISO-8859-1'); 
  $org_buf = substr($org_buf, 0, strpos($org_buf, 0));
  mb_internal_encoding($enc);
  return $org_buf;
}

function geoip_org_by_addr ($gi,$addr) {
  if ($addr == NULL) {
    return 0;
  }
  $ipnum = ip2long($addr);
  return _get_org($gi, $ipnum);
}

function _get_region($gi,$ipnum){
  if ($gi->databaseType == GEOIP_REGION_EDITION_REV0){
    $seek_region = _geoip_seek_country($gi,$ipnum) - GEOIP_STATE_BEGIN_REV0;
    if ($seek_region >= 1000){
      $country_code = "US";
      $region = chr(($seek_region - 1000)/26 + 65) . chr(($seek_region - 1000)%26 + 65);
    } else {
            $country_code = $gi->GEOIP_COUNTRY_CODES[$seek_region];
      $region = "";
    }
  return array ($country_code,$region);
    }  else if ($gi->databaseType == GEOIP_REGION_EDITION_REV1) {
    $seek_region = _geoip_seek_country($gi,$ipnum) - GEOIP_STATE_BEGIN_REV1;
    //print $seek_region;
    if ($seek_region < US_OFFSET){
      $country_code = "";
      $region = "";  
        } else if ($seek_region < CANADA_OFFSET) {
      $country_code = "US";
      $region = chr(($seek_region - US_OFFSET)/26 + 65) . chr(($seek_region - US_OFFSET)%26 + 65);
        } else if ($seek_region < WORLD_OFFSET) {
      $country_code = "CA";
      $region = chr(($seek_region - CANADA_OFFSET)/26 + 65) . chr(($seek_region - CANADA_OFFSET)%26 + 65);
    } else {
            $country_code = $gi->GEOIP_COUNTRY_CODES[($seek_region - WORLD_OFFSET) / FIPS_RANGE];
      $region = "";
    }
  return array ($country_code,$region);
  }
}

function geoip_region_by_addr ($gi,$addr) {
  if ($addr == NULL) {
    return 0;
  }
  $ipnum = ip2long($addr);
  return _get_region($gi, $ipnum);
}

function getdnsattributes ($l,$ip){
  $r = new Net_DNS_Resolver();
  $r->nameservers = array("ws1.maxmind.com");
  $p = $r->search($l."." . $ip .".s.maxmind.com","TXT","IN");
  $str = is_object($p->answer[0])?$p->answer[0]->string():'';
  ereg("\"(.*)\"",$str,$regs);
  $str = $regs[1];
  return $str;
}

?>

