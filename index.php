<html>

<head>
<title>Arduino Meteo Station</title>
  <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
  <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = //insert your ZC licence;
  </script>
  <link href='//fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
  <link href='//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <style>
    #controls {
      position: absolute;
      top: 25px;
      left: 30px;
      z-index: 100;
    }
    
    #controls > span {
      display: inline-block;
      margin-left: 10px;
      background-color: #01579B;
      color: #FFF;
      padding: 5px 10px;
      margin-bottom: 5px;
      border-radius: 5px;
      -webikit-border-radius: 5px;
    }
    
    #controls > span:hover {
      cursor: pointer;
      background-color: #41B6C4;
    }
  </style>
  
   <script>
	<?php		
		$date = date('W', time());
		$mysqli = new mysqli("adress", "user", "pass", "base");
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
		exit();}
		$temp_lundi=mysqli_query($mysqli,"SELECT EXTRACT(hour FROM time) as timehour,round(avg(temp),2) as temp FROM sensor WHERE DAYNAME(time)='Monday' and WEEKOFYEAR(time)='$date' and ARDUINO='uno' GROUP BY timehour");
		$temp_mardi=mysqli_query($mysqli,"SELECT EXTRACT(hour FROM time) as timehour,round(avg(temp),2) as temp FROM sensor WHERE DAYNAME(time)='Tuesday' and WEEKOFYEAR(time)='$date' and ARDUINO='uno' GROUP BY timehour");
		$temp_mercredi=mysqli_query($mysqli,"SELECT EXTRACT(hour FROM time) as timehour,round(avg(temp),2) as temp FROM sensor WHERE DAYNAME(time)='Wednesday' and WEEKOFYEAR(time)='$date' and ARDUINO='uno' GROUP BY timehour");
		$temp_jeudi=mysqli_query($mysqli,"SELECT EXTRACT(hour FROM time) as timehour,round(avg(temp),2) as temp FROM sensor WHERE DAYNAME(time)='Thursday' and WEEKOFYEAR(time)='$date' and ARDUINO='uno' GROUP BY timehour");
		$temp_vendredi=mysqli_query($mysqli,"SELECT EXTRACT(hour FROM time) as timehour,round(avg(temp),2) as temp FROM sensor WHERE DAYNAME(time)='Friday' and WEEKOFYEAR(time)='$date' and ARDUINO='uno' GROUP BY timehour");
		$temp_samedi=mysqli_query($mysqli,"SELECT EXTRACT(hour FROM time) as timehour,round(avg(temp),2) as temp FROM sensor WHERE DAYNAME(time)='Saturday' and WEEKOFYEAR(time)='$date' and ARDUINO='uno' GROUP BY timehour");
		$temp_dimanche=mysqli_query($mysqli,"SELECT EXTRACT(hour FROM time) as timehour,round(avg(temp),2) as temp FROM sensor WHERE DAYNAME(time)='Sunday' and WEEKOFYEAR(time)='$date' and ARDUINO='uno' GROUP BY timehour");
		$hours=mysqli_query($mysqli,"SELECT DISTINCT(EXTRACT(hour FROM time)) as time FROM sensor");
	?>
</script>

<script>
  $( function() {
	$.datepicker.regional['fr'] = {
    closeText: 'Fermer',
    prevText: 'Précédent',
    nextText: 'Suivant',
    currentText: 'Aujourd\'hui',
    monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
    monthNamesShort: ['Janv.','Févr.','Mars','Avril','Mai','Juin','Juil.','Août','Sept.','Oct.','Nov.','Déc.'],
    dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
    dayNamesShort: ['Dim.','Lun.','Mar.','Mer.','Jeu.','Ven.','Sam.'],
    dayNamesMin: ['D','L','M','M','J','V','S'],
    weekHeader: 'Sem.',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};
	$.datepicker.setDefaults($.datepicker.regional['fr']);
    $( "#datepicker" ).datepicker({showWeek: true});
  })
</script>

</head>

<body>

<p><input type="text" id="datepicker"></p>


	
	<div id='myChart'></div>
	
	<script>			
		var mytemplundi=[<?php 
		while($info=mysqli_fetch_array($temp_lundi))
		echo $info['temp'].','; ?>];
		var mytempmardi=[<?php 
		while($info=mysqli_fetch_array($temp_mardi))
		echo $info['temp'].','; ?>];
		var mytempmercredi=[<?php 
		while($info=mysqli_fetch_array($temp_mercredi))
		echo $info['temp'].','; ?>];
		var mytempjeudi=[<?php 
		while($info=mysqli_fetch_array($temp_jeudi))
		echo $info['temp'].','; ?>];
		var mytempvendredi=[<?php 
		while($info=mysqli_fetch_array($temp_vendredi))
		echo $info['temp'].','; ?>];
		var mytempsamedi=[<?php 
		while($info=mysqli_fetch_array($temp_samedi))
		echo $info['temp'].','; ?>];
		var mytempdimanche=[<?php 
		while($info=mysqli_fetch_array($temp_dimanche))
		echo $info['temp'].','; ?>];

		var myheure=[<?php 
		while($info=mysqli_fetch_array($hours))
		echo $info['time'].','; ?>];

	
    var myConfig = {
      "globals": {
        "font-family": "Roboto",
      },
      "graphset": [{
        "type": "piano",
        "theme": "classic",
        "title": {
          "text": "Température",
          "background-color": "none",
          "font-color": "#05636c",
          "font-size": "24px",
          "adjust-layout": true,
          "padding-bottom": 25
        },
        "backgroundColor": "#fff",
        "plotarea": {
          "margin": "dynamic"
        },
        "scaleX": {
          "placement": "opposite",
          "lineWidth": 0,
		  "label":{"text":"Heures du jour"},
          "item": {
            "border-color": "none",
            "size": "13px",
            "font-color": "#05636c"
          },
          "guide": {
            "visible": false
          },
          "tick": {
            "visible": false
          },
          //"values": myheure
		  "values": ["0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23"],

        },
        "scaleY": {
          "lineWidth": 0,
          "mirrored": true,
          "tick": {
            "visible": false
          },
          "guide": {
            "visible": false
          },
          "item": {
            "border-color": "none",
            "size": "13px",
            "font-color": "#05636c"
          },
		"values":['Lu','Ma','Me','Je','Ve','Sa','Di'],
        },
        "plot": {
          "aspect": "none",
		  "value-box": {
			  "font-color":"white",
			  "font-size":10,
			"rules":[
				{
				"rule":"%v == 0",
				"visible":false
				}]
		  },
          "borderWidth": 2,
          "borderColor": "#eeeeee",
          "borderRadius": 7,
          "tooltip": {
            "font-size": "14px",
			"visible":false,
            "font-color": "white",
            "text": " Il a fait %v °C en moyenne.",
            "text-align": "left"
          },
		"rules":[
				{
					"rule":"%v >= 22", 
					"text":"%v",
					"background-color":"#FF0000"
				},
				{
					"rule":"%v < 22 && %v >= 21.50",
					"background-color":"#8F701C" 
				},
				{
					"rule":"%v < 21.50 && %v >= 21",
					"value-box": {},
					"background-color":"#669926" 
				},
				{
					"rule":"%v < 21 && %v >= 20.50",
					"background-color":"#52AD2B" 
				},
				{
					"rule":"%v < 20.50 && %v >= 19.50",
					"background-color":"#33CC33" 
				},
				{
					"rule":"%v < 19.50 && %v >= 19",
					"background-color":"#2BAD52" 
				},
				{
					"rule":"%v < 19 && %v >= 18.50",
					"background-color":"#269966" 
				},
				{
					"rule":"%v < 18.50 && %v >= 18",
					"background-color":"#1C708F" 
				},				
				{
					"rule":"%v == 0",
					"background-color":"#FFFFFF", //blanc
					"borderWidth": 0,
					"borderColor": "#FFFFFF"
				},
				{
					"rule":"%v < 18 && %v > 1",
					"background-color":"#0000FF" //rouge
				}
				]
        },
        "series": [
		{"values":mytemplundi},
		{"values":mytempmardi},
		{"values":mytempmercredi},
		{"values":mytempjeudi},
		{"values":mytempvendredi},
		{"values":mytempsamedi},
		{"values":mytempdimanche}
		]
      }]
    };

    zingchart.render({
      id: 'myChart',
      data: myConfig,
      height: 500,
      width: '100%'
    });
	
  </script>
</body>

</html>