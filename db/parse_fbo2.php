<?php

$record_type = 0;
$PRESOL = 1;
$SRCSGT = 2;
$COMBINE = 3;

$tag = array();
$main_tag = array();
$presol_tag = array();
$srcsgt_tag = array();
$combine_tag = array();

$main_tag[] = "<PRESOL>";
$main_tag[] = "<SRCSGT>";
$main_tag[] = "<COMBINE>";

$presol_tag[] = "<DATE>";
$presol_tag[] = "<YEAR>";
$presol_tag[] = "<AGENCY>";
$presol_tag[] = "<OFFICE>";
$presol_tag[] = "<LOCATION>";
$presol_tag[] = "<CLASSCOD>";
$presol_tag[] = "<NAICS>";
$presol_tag[] = "<OFFADD>";
$presol_tag[] = "<SUBJECT>";
$presol_tag[] = "<SOLNBR>";
$presol_tag[] = "<ARCHDATE>";
$presol_tag[] = "<CONTACT>";
$presol_tag[] = "<DESC>";
$presol_tag[] = "<LINK>";
$presol_tag[] = "<URL>";
$presol_tag[] = "<SETASIDE>";
$presol_tag[] = "<POPCOUNTRY>";
$presol_tag[] = "<POPADDRESS>";
$presol_tag[] = "</PRESOL>";

$srcsgt_tag[] = "<DATE>";
$srcsgt_tag[] = "<YEAR>";
$srcsgt_tag[] = "<AGENCY>";
$srcsgt_tag[] = "<OFFICE>";
$srcsgt_tag[] = "<LOCATION>";
$srcsgt_tag[] = "<ZIP>";
$srcsgt_tag[] = "<CLASSCOD>";
$srcsgt_tag[] = "<NAICS>";
$srcsgt_tag[] = "<OFFADD>";
$srcsgt_tag[] = "<SUBJECT>";
$srcsgt_tag[] = "<SOLNBR>";
$srcsgt_tag[] = "<RESPDATE>";
$srcsgt_tag[] = "<CONTACT>";
$srcsgt_tag[] = "<DESC>";
$srcsgt_tag[] = "<LINK>";
$srcsgt_tag[] = "<URL>";
$srcsgt_tag[] = "<DESC>";
$srcsgt_tag[] = "<SETASIDE>";
$srcsgt_tag[] = "<POPCOUNTRY>";
$srcsgt_tag[] = "<POPZIP>";
$srcsgt_tag[] = "<POPADDRESS>";
$srcsgt_tag[] = "</SRCSGT>";


$combine_tag[] ="<DATE>";
$combine_tag[] ="<YEAR>";
$combine_tag[] ="<AGENCY>";
$combine_tag[] ="<OFFICE>";
$combine_tag[] ="<LOCATION>";
$combine_tag[] ="<ZIP>";
$combine_tag[] ="<CLASSCOD>";
$combine_tag[] ="<NAICS>";
$combine_tag[] ="<OFFADD>";
$combine_tag[] ="<SUBJECT>";
$combine_tag[] ="<SOLNBR>";
$combine_tag[] ="<RESPDATE>";
$combine_tag[] ="<ARCHDATE>";
$combine_tag[] ="<CONTACT>";
$combine_tag[] ="<DESC>";
$combine_tag[] ="<LINK>";
$combine_tag[] ="<URL>";
$combine_tag[] ="<DESC>";
$combine_tag[] ="<SETASIDE>";
$combine_tag[] ="<POPCOUNTRY>";
$combine_tag[] ="<POPZIP>";
$combine_tag[] ="<POPADDRESS>";
$combine_tag[] = "</COMBINE>";


$main_tags = count($main_tag);
$presol_tags = count($presol_tag);
$srcsgt_tags = count($srcsgt_tag);
$combine_tags = count($combine_tag);





$myfile = fopen("FBOFeed20171117", "r") or die("Unable to open file!");
// Output one line until end-of-file

$current_tag = '';
$last_tag = ''; //used to skip all lines after <DESC> tag until the next tag is found.


$record_type = 0;
$PRESOL = 1;
$SRCSGT = 2;
$COMBINE = 3;



while(!feof($myfile)) 
{
	$one_line = fgets($myfile);
	
	$taglen = strlen();
	 
	if (substr($one_line,0,8) == "<PRESOL>")
	{
		$current_tag = '';
		$last_tag = '';
		
		while ($current_tag <> "</PRESOL>")
		{
			one_line = fgets($myfile);
				
			for (x=0;x < $presol_tags;x++)
			{
				$taglen = strlen($presol_tag[$x]);
				
				if (substr($one_line,0,$taglen) == $presol_tag[$x])
					$current_tag = $presol_tag[$x];
			}
			
			if (($current_tag <> "<DESC>") and ($current_tag <> "</PRESOL>"))
				
		}
	}
	else if (substr($one_line,0,8) == "<SRCSGT>")
	{
	}
	else if (substr($one_line,0,9) == "<COMBINE>")
	{
	}
	else
		continue;
}



		
  
	//check for main tag
	
	$current_tag = substr($one_line,0,$taglen);
	
	switch ($current_tag)
	{
		case "<PRESOL>":
			$record_type = $PRESOL;
			
			while ($current_tag <> "</PRESOL>")
			{
				one_line = fgets($myfile);
				
				for (x=0;x < $presol_tags;x++)
				{
					
				}
			}
			
			break;
		case "<SRCSGT>":
			$record_type = $SRCSGT;
			break;
		case "COMBINE":
			$record_type = $COMBINE;
			break;
		default:
			$record_type = 0;	
	}
	
	
	
	
				
				
				
				$cur_maintag_beg = $main_tag[$x];
				$cur_maintag_end = $main_tag[$x+1];	
				
				
				$current_tag = $tag[$x];
				$last_tag = '';
				break;
			}
	}  
  
	for ($x=0;x < $main_tags;x++)
	{
		

		
		$cur_maintag_beg = $main_tag[$x];
		$cur_maintag_end = $main_tag[$x+1];
	}
	
		switch ($main_tag[x])
		{
			case "<PRESOL>":
				$PRESOL = 1; //start reading presol tags
				echo  substr($one_line,1,$taglen-1). substr($one_line,$taglen) . "<br>";
				break;
					
			case "</PRESOL>":
				$PRESOL = 2;
				echo  substr($one_line,1,$taglen-1). substr($one_line,$taglen) . "<br>";
				echo "Writing Record to Database<br>";					
				break;
					
				case "<SRCSGT>":
					$SRCSGT = 1;
					echo  substr($one_line,1,$taglen-1). substr($one_line,$taglen) . "<br>";
					break;
					
				case "</SRCSGT>":
					$SRCSGT = 2;
					echo  substr($one_line,1,$taglen-1). substr($one_line,$taglen) . "<br>";
					echo "Writing Record to Database<br>";					
					break;
				
				case "<COMBINE>":
					$COMBINE = 1;
					echo  substr($one_line,1,$taglen-1). substr($one_line,$taglen) . "<br>";
					break;
					
				case "</COMBINE>":
					$COMBINE = 2;
					echo  substr($one_line,1,$taglen-1). substr($one_line,$taglen) . "<br>";
					echo "Writing Record to Database<br>";
					break;
					
				case "<DESC>":
				    $last_tag = "DESC";
					break;				
	
	
  
  
  
  $current_tag = '';
  
  
  

  
  for($x=0;$x < $numtags;$x++)
  {
		$taglen = strlen($tag[$x]);
  
	    if (substr($one_line,0,$taglen) == $tag[$x])
		{
			$current_tag = $tag[$x];
			$last_tag = '';
			break;
		}
  }

			switch ($current_tag)
			{
				case "<PRESOL>":
					$PRESOL = 1; //start reading presol tags
					echo  substr($one_line,1,$taglen-1). substr($one_line,$taglen) . "<br>";
					break;
					
				case "</PRESOL>":
					$PRESOL = 2;
					echo  substr($one_line,1,$taglen-1). substr($one_line,$taglen) . "<br>";
					echo "Writing Record to Database<br>";					
					break;
					
				case "<SRCSGT>":
					$SRCSGT = 1;
					echo  substr($one_line,1,$taglen-1). substr($one_line,$taglen) . "<br>";
					break;
					
				case "</SRCSGT>":
					$SRCSGT = 2;
					echo  substr($one_line,1,$taglen-1). substr($one_line,$taglen) . "<br>";
					echo "Writing Record to Database<br>";					
					break;
				
				case "<COMBINE>":
					$COMBINE = 1;
					echo  substr($one_line,1,$taglen-1). substr($one_line,$taglen) . "<br>";
					break;
					
				case "</COMBINE>":
					$COMBINE = 2;
					echo  substr($one_line,1,$taglen-1). substr($one_line,$taglen) . "<br>";
					echo "Writing Record to Database<br>";
					break;
					
				case "<DESC>":
				    $last_tag = "DESC";
					break;					
					
				 default:
				    //map data to db field function
					if ($last_tag != 'DESC')
						echo  substr($one_line,1,$taglen-1). substr($one_line,$taglen) . "<br>";
				

			}
			/*
			if ($last_tag != 'DESC')
				echo  substr($one_line,1,$taglen-1). substr($one_line,$taglen) . "<br>";
			*/
		
  }
 
fclose($myfile);

/*
$myfile = fopen("FBOFeed20171117", "r") or die("Unable to open file!");
echo fgets($myfile);
fclose($myfile);
*/

?>


