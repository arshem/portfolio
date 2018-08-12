<?php

/***
* 
* OxfordAPI Class
* 
* This will allow definitions, translations, and lookup of Synonyms and Antonyms
* 
* Written by: Brandon Wright
* https://github.com/arshem/portfolio
* https://www.arshem.com
* 
***/
class OxfordAPI {
	protected $apiURL; // API URL's Constant
	protected $type; // Search Type, Dictionary, Thesaurus, Translate

	function __construct($type,$word,$lang="en",$lang2="es") {
		$apiURL = "https://od-api.oxforddictionaries.com/api/v1/entries/".$lang."/";
	    switch($type) {
	      case 'dictionary':
	        $apiURL = $apiURL.strtolower(urlencode($word));
	      break;
	      case 'thesaurus':
	        $apiURL = $apiURL.strtolower(urlencode($word))."/synonyms;antonyms";
	      break;
	      case 'translate':
	        $apiURL = $apiURL.strtolower(urlencode($word))."/translations=".$lang2;
	    }
	    $this->apiURL = $apiURL;
	    $this->type = $type;
	}

	function get($app_id,$app_key) {
		$ch = curl_init($this->apiURL);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	    $headers = [
	      "Accept: application/json",
	      "app_id:".$app_id,
	      "app_key:".$app_key
	    ];
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    $output = curl_exec($ch);
	    $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
	    curl_close($ch);
		$info = json_decode($output);

	    switch($this->type) {
	    	case 'dictionary':
	    		if($http_code==200) {
		    		return $this->dictionary($info);
				} else {
					return $http_code;
				}
	    	break;
	    	case 'thesaurus':
	    		if($http_code==200) {
		    		return $this->thesaurus($info);
				} else {
					return $http_code;
				}
	    	break;
	    	case 'translate':
	    		if($http_code==200) {
		    		return $this->translate($info);
				} else {
					return $http_code;
				}
	    	break;
	    }
  	}

  	function dictionary($result) {

  		$lex = $result->results[0]->lexicalEntries;
  		$definitions = [];

  		foreach($lex as $x) {
  			if(property_exists($x, 'entries')) {
  				foreach($x->entries as $ent) {
  					if(property_exists($ent, 'senses')) {
  						foreach($ent->senses as $sense) {
  							if(property_exists($sense, "definitions")) {
	  							foreach($sense->definitions as $definition) {
	  								$definitions[] = str_replace(':','',$definition);
	  							}
	  						}
	  						if(property_exists($sense, "crossReferenceMarkers")) {
	  							foreach($sense->crossReferenceMarkers as $cRM) {
	  								$definitions[] = str_replace(':','',$cRM);
	  							}
	  						}
  						}
  					}
  				}
  			}
  		}

  		return array_unique($definitions);
  	}

  	function thesaurus($result) {

  		$lex = $result->results[0]->lexicalEntries;
  		$data = [];

  		foreach($lex as $x) {
  			if(property_exists($x, 'entries')) {
  				foreach($x->entries as $ent) {
  					if(property_exists($ent, 'senses')) {
  						foreach($ent->senses as $sense) {
  							if(property_exists($sense, "synonyms")) {
  								foreach($sense->synonyms as $synoym) {
  									$data["synonyms"][] = $synoym->text;
  								}
  							}
  							if(property_exists($sense, "antonyms")) {
  								foreach($sense->antonyms as $antonym) {
  									$data["antonyms"][] = $antonym->text;
  								}
  							}
  						}
  					}
  				}
  			}
  		}
  		if(isset($data["synonyms"]))
	  		$data["synonyms"] = array_unique($data["synonyms"]);
  		if(isset($data["antonyms"]))
	  		$data["antonyms"] = array_unique($data["antonyms"]);
  	
  		return $data;
  	}

  	function translate($result) {
  		$senses = $result->results[0]->lexicalEntries[0]->entries[0]->senses;
  		$words = [];
  		foreach($senses as $sense) {
  			if(property_exists($sense, "subsenses")) {
  				foreach($sense->subsenses as $subsense) {
  					if(property_exists($subsense, "translations")) {
  						foreach($subsense->translations as $translation) {
  							$words[] = $translation->text;
  						}
  					}
  				}
  			}
  			if(property_exists($sense, "translations")) {
  				foreach($sense->translations as $translation) {
  					$words[] = $translation->text;
  				}
  			}
  		}
  		return array_unique($words);
  	}

}