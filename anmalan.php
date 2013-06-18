<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
<head>
    <title>Anmälan</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
var chosenStarts = 0;
var starts = new Array();
var chStarts = new Array();
var maxStarts = 2;
var timer;
var TIME_OUT = 750;

function toggleStarts(id) {
    if (id==starts[0] || id==starts[1]) {
        document.getElementById(id).style.color = "rgb(63,55,49)";
        document.getElementById(id).style.borderColor = "#cdc3b7";
        starts[ (id==starts[0]? 0 : 1) ] = null;
    } else if (starts[0]== null || starts[1]==null) {
        document.getElementById(id).style.color = "rgb(255,0,0)";
        document.getElementById(id).style.borderColor = "rgb(0,0,0)";
        starts[ (starts[0]==null? 0 : 1) ] = id;
    } else {
        document.getElementById(id).style.color = "rgb(63,55,49)";
        document.getElementById(id).style.borderColor = "#cdc3b7";
    }
    val_starter();
}

function toggleChStarts(id) {
    if (id==chStarts[0] || id==chStarts[1]) {
        document.getElementById(id).style.color = "rgb(63,55,49)";
        document.getElementById(id).style.borderColor = "#cdc3b7";
        chStarts[ (id==chStarts[0]? 0 : 1) ] = null;
    } else if (chStarts[0]== null || chStarts[1]==null) {
        document.getElementById(id).style.color = "rgb(255,0,0)";
        document.getElementById(id).style.borderColor = "rgb(0,0,0)";
        chStarts[ (chStarts[0]==null? 0 : 1) ] = id;
    } else {
        document.getElementById(id).style.color = "rgb(63,55,49)";
        document.getElementById(id).style.borderColor = "#cdc3b7";
    }
}

function val_starter() {
    if (starts[0]==null && starts[1]==null) {
        document.getElementById("starter_fel").style.visibility = "visible";
    } else {
        document.getElementById("starter_fel").style.visibility = "hidden";
    }
}

function checkErr(id,focusOut) {
	if (focusOut
			|| (id=="tfnnummer" && document.getElementById(id).value.length > 7)
			|| (id=="passwd" && document.getElementById(id).value.length > 5)
			|| (id=="fornamn" && document.getElementById(id).value.length > 3)
			|| (id=="efternamn" && document.getElementById(id).value.length > 2)
			|| (id=="klubb" && document.getElementById(id).value.length > 5)) {
		var postdata = {};
		postdata[id] = $("#" + id).attr("value");
		$.post(id + "_verify.php", postdata,
			function(ret) {
				document.getElementById(id + "_fel").style.visibility =
					(ret=="ok" ? "hidden" : "visible");
				if (id=="passwd" && (document.getElementById("passwdver").value.length > 0))
					checkPass(focusOut);
			});
	}
}

function checkPass(focusOut) {
	if (focusOut)
		document.getElementById("passwdver_fel").style.visibility =
			($("#passwd").attr("value")==$("#passwdver").attr("value") ? "hidden" : "visible");
	else {
		var passwd = $("#passwd").attr("value");
		var passwdver = $("#passwdver").attr("value");
		if (passwdver.length==0)
			return;
		if (passwd==passwdver)
			document.getElementById("passwdver_fel").style.visibility = "hidden";
		else if (passwd.substr(0,passwdver.length)!=passwdver)
			document.getElementById("passwdver_fel").style.visibility = "visible";
	}
}

$(function(){

    $("#alter_player").hide();
    
    $("#ch_password_tr").hide();
    
    $("#ch_submit_span").hide();
    
    $("#registered_players").change(function(){
        var val = $("#registered_players").val();
        if (val=="noop")
            return;
        $(".ch_start_button").each(function(){$(this).button("disable")});
        $.post("returnstarts.php", { id : val  },
            function(ret){
                $("#alter_player").show("slow");
                $("#ch_password_tr").show("slow");    
                $("#ch_submit_span").show("slow");
                $(".ch_start_button").each(function(){
                    document.getElementById($(this).attr("id")).style.color = "rgb(63,55,49)";
                    document.getElementById($(this).attr("id")).style.borderColor = "#cdc3b7";
                });
                chStarts[0] = null;
                chStarts[1] = null;
                toggleChStarts("ch_" + ret.substring(0,10));
                if (ret.substring(10)!="")
                    toggleChStarts("ch_" + ret.substring(10));
                $(".ch_start_button").each(function(){$(this).button("enable");});
                $(".disabled_button").each(function(){
                    if (!($(this).attr("id")==chStarts[0] || 
                            $(this).attr("id")==chStarts[0])) {
                        $(this).button("disable");
                    }
                    
                });
            });
    });

    $("#ch_submit").button();

    $("#ch_submit").click(function(event){
        event.preventDefault();
        var thisButton = $(this);
        $(this).button("disable");
        $(this).button("option","label","Jobbar...");
        var data = {};
        data["id"] = $("#registered_players").val();
        if (chStarts[0]!=null)
            data["start1"] = chStarts[0];
        if (chStarts[1]!=null)
            data["start2"] = chStarts[1];
        data["password"] = $("#ch_password").val();
        $.post("change.php", data, function(ret) {
            if (ret=="passwd") {
                thisButton.button("option","disabled",false);
                thisButton.button("option","label","Ändra");
                alert('Lösenordet är fel.');
            } else if (ret=="dbfault") {
                thisButton.button("option","disabled",false);
                thisButton.button("option","label","Ändra");
                alert("Ett tekniskt fel inträffade. Försök igen, fungerar det inte så ring hallen på 031-221517 eller kontakta oss via formuläret under Kontakt i menyn ovan.");
            } else {
                $("#change_stuff").hide("slow",function() {
                    $("#anmalan_content").html("<h4>Ladda om sidan (tryck F5 exempelvis) för att kunna göra en bokning.</h4>");
                    $("#change_stuff").html(ret); 
                    $("#change_stuff").show("slow"); 
                });
            }
        });
    });

    $(".start_button").button();
    
    $(".disabled_start_button").button().button("disable");
    
    $(".ch_start_button").button();
    
    $(".start_button").click(function(event){
        toggleStarts($(this).attr("id"));
    });

    $(".ch_start_button").click(function(event){
        toggleChStarts($(this).attr("id"));
    });

    $(".form_field").attr("style","width:65%;");

    $(".form_field").focusout(function(){
		checkErr($(this).attr("id"),true);
    });

	$(".form_field").keyup(function() {
		var id = $(this).attr("id");
		clearTimeout(timer);
		timer = setTimeout("checkErr('" + id + "');",TIME_OUT);
	});
	
    $("#passwdver").focusout(function() {
        checkPass(true);
    });

    $("#passwdver").keyup(function() {
		if ($(this).val().length > 0){
			clearTimeout(timer);
			timer = setTimeout("checkPass();",TIME_OUT);
		}
    });
	
    $("#submitbutton").button();
    
    $("#submitbutton").click(function(event){
        event.preventDefault();
        var thisButton = $(this);
        $(this).button("disable");
        $(this).button("option","label","Jobbar...");
        var data = {};
        data["fornamn"] = $("#fornamn").attr("value");
        data["efternamn"] = $("#efternamn").attr("value");
        data["klubb"] = $("#klubb").attr("value");
        data["tfnnummer"] = $("#tfnnummer").attr("value");
        data["passwd"] = $("#passwd").attr("value");
        data["passwdver"] = $("#passwdver").attr("value");
        if (starts[0]!=null)
            data["start1"] = starts[0];
        if (starts[1]!=null)
            data["start2"] = starts[1];
        $.post("book.php", data,
            function(ret) {
                if (ret=="denied") {
                    thisButton.button("option","disabled",false);
                    thisButton.button("option","label","Boka");
                    alert("Det finns fel i din anmälan.");
                    $(".form_field").focusout();
					checkPass(true);
                    val_starter();
                } else if (ret=="dbfault") {
                    thisButton.button("option","disable",false);
                    thisButton.button("option","label","Boka");
                    alert("Ett tekniskt fel inträffade. Försök igen, fungerar det inte så ring hallen på 031-221517 eller kontakta oss via formuläret under Kontakt i menyn ovan.");
                } else {
                    $("#anmalan_content").hide("slow", function() {
                        $("#change_stuff").html("<h4>Ladda om sidan (tryck F5 exempelvis) för att kunna ändra bokningar.</h4>");
                        $("#anmalan_content").html(ret);
                        $("#anmalan_content").show("slow");
                    });
                }
        });
    });

    $("#anm_acc").accordion({ header: "h3",
                              autoHeight: false,
                              collapsible: true,
                              active: false });

});
</script>
</head>
<body>

    <h2>Anmälan</h2>
    <p> Här kan du anmäla dig till tävlingen. Välj ett av följande alternativ:
    </p>
	<p><strong>Anmälan är bindande 24 timmar innan start.</strong>
	</p>
<p style="color:rgb(255,0,0)">
<strong>Denna sida fungerar dåligt på mobiltelefoner. Inom kort kommer ett förenklat formulär som alternativ.</strong>
</p>
    <div id="anm_acc">
        <h3><a href="#anmalan_content">Jag vill anmäla mig.</a></h3>
            <div id="anmalan_content">
                <form name="ny_anmalan" target="ny_anmalan.php" method="POST">
                <p>
                    <table width="100%">
                    <tr>
                        <td>
                            Förnamn:
                        </td>
                        <td>
                            <input type="text" name="fornamn" id="fornamn" class="form_field"/>
                        </td>
                        <td style="width:50%;">
		<div class="ui-widget" id="fornamn_fel" style="visibility:hidden;">
			<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
				<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
				<strong>Fel format:</strong> Endast bokstäver är tillåtna. Fältet får inte vara tomt.</p>
			</div>
		</div>
		            </td>
                    </tr>
                    <tr>
                        <td>
                            Efternamn:
                        </td>
                        <td>
                            <input type="text" name="efternamn" id="efternamn" class="form_field"/>
                        </td>
                        <td>
		<div class="ui-widget" id="efternamn_fel" style="visibility:hidden;">
			<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
				<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
				<strong>Fel format:</strong> Endast bokstäver är tillåtna. Fältet får inte vara tomt.</p>
			</div>
		</div>
		            </td>
                    </tr>
                    <tr>
                        <td>
                            Klubb:
                        </td>
                        <td>
                            <input type="text" name="klubb" id="klubb" class="form_field"/>
                        </td>
                        <td>
		<div class="ui-widget" id="klubb_fel" style="visibility:hidden;">
			<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
				<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
				<strong>Fel format:</strong> Otillåtna tecken i klubbnamnet. Fältet får inte vara tomt.</p>
			</div>
		</div>
		            </td>
                    </tr>
                    <tr>
                        <td>
                            Telefonnummer (utan bindestreck eller blanksteg):
                        </td>
                        <td>
                            <input type="text" name="tfnnummer" id="tfnnummer" class="form_field"/>
                        </td>
                        <td>
		<div class="ui-widget" id="tfnnummer_fel" style="visibility:hidden;">
			<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
				<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
				<strong>Fel format:</strong> Ange ditt telefonnummer inklusive riktnummer, utan bindestreck eller mellanslag. Fältet får inte vara tomt. Max 15 tecken.</p>
			</div>
		</div>
		            </td>
                    </tr>
                    <tr>
                        <td>
                            Välj start/er genom att klicka (max två):
                        </td>
                        <td>
                            <div id="starter">
<?php
include('connectdb.php');

$query = mysql_query("SELECT* FROM StartAvail");
$i = 0;
while ($row = mysql_fetch_assoc($query)) {
    $disable = $row['count'] == $row['platser'];
    echo "<button id=". $row['dag'] . $row['tid'] .
        " type=\"button\" class=\"". ($disable?"disabled_start_button":"start_button") ."\" style=\"width:100%\">" .
        utf8_encode($row['info']) . " (" .
        $row['count']. "/" .
        $row['platser']. " bokade)" .
        "</button>";
}
include('closedb.php');
?>
                            </div>
                        </td>
                        <td>
		<div class="ui-widget" id="starter_fel" style="visibility:hidden;">
			<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
				<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
				<strong>Fel:</strong> Du måste välja en start.</p>
			</div>
		</div>
		            </td>
                    </tr>
                    <tr>
                        <td>
                            Välj lösenord (för av/ombokning):
                        </td>
                        <td>
                            <input type="password" name="passwd" id="passwd" class="form_field"/>
                        </td>
                        <td>
		<div class="ui-widget" id="passwd_fel" style="visibility:hidden;">
			<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
				<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
				<strong>Fel format:</strong> Lösenordet ska vara 6-15 tecken och får innehålla a-z, A-Z och/eller 0-9.</p>
			</div>
		</div>
		            </td>
                    </tr>
                    <tr>
                        <td>
                            Ange lösenord igen:
                        </td>
                        <td>
                            <input type="password" name="passwdver" id="passwdver" style="width:65%"/>
                        </td>
                        <td>
		<div class="ui-widget" id="passwdver_fel" style="visibility:hidden;">
			<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
				<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
				<strong>Fel:</strong> Lösenorden stämmer ej överens. Fältet får inte vara tomt.</p>
			</div>
		</div>
		            </td>
                    </tr>
                </table>
                </p>
                <input value="Boka" type="submit" id="submitbutton"/>
                </form>
            </div>

        <h3><a href="#change_stuff">Jag vill boka ytterligare en start / ändra start /
                avanmäla mig.</a></h3>
            <div id="change_stuff">
                <table width="50%">
                    <tr>
                        <td>
                            Välj spelare:
                        </td>
                        <td>
                            <select name="registered_players" id="registered_players">
                            <option value="noop">Välj</option>
<?php
include('connectdb.php');

$query_string = "SELECT id, firstname, lastname, klubb FROM Players " . 
                    "ORDER BY firstname ASC, lastname ASC;";
$query = mysql_query($query_string);

while($arr = mysql_fetch_assoc($query)) {
    echo "<option value=" . $arr['id'] . ">" . $arr['firstname'] . " " .
            $arr['lastname'] . ", " . $arr['klubb'];
}

include('closedb.php');
?>
                            </select>
                        </td>
                    </tr>
                    <tr id="alter_player">
                        <td>
                            Ändra starter:
                        </td>
                        <td id="alter_starts">
<?php
include('connectdb.php');

$query = mysql_query("SELECT* FROM StartAvail");
$i = 0;
while ($row = mysql_fetch_assoc($query)) {
    $disable = $row['count'] == $row['platser'];
    echo "<button id=ch_". $row['dag'] . $row['tid'] .
        " type=\"button\" class=\"ch_start_button ". ($disable ? "disabled_button" : "") .
        "\" style=\"width:70%\">" .
        utf8_encode($row['info']) . " (" .
        $row['count']. "/" .
        $row['platser']. " bokade)" .
        "</button>";
}

include('closedb.php');
?>
                        </td>
                    </tr>
                    <tr id="ch_password_tr">
                        <td>
                            Ange lösenord:
                        </td>
                        <td>
                            <input type="password" id="ch_password">
                        </td>
                    </tr>
                </table>
                <span id="ch_submit_span">
                <input type="submit" value="Ändra" id="ch_submit">
                </span>
            </div>

    </div>
    

    
</body>
</html>
