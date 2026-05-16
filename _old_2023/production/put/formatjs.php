<?php
function FormatJS($json)
{
    #start array
    $array = json_decode($json);

    #helpers
    $root = $array->RootNode;
    $obj__1 = $root->Lines;
    $obj__2 = $root->Stations;

    #for list
    $elements = $array->ElementsOK;

    $substation = [
        "GeneratedPower" => IfNull(round($root->GeneratedPower), RandomPower()),
        "ID" => "Substation",
        "IsON" => true,
        "RequiredPower" => IfNull(round($root->RequiredPower), RandomPower()),
    ];

    $solarBattery1 = [
        "GeneratedPower" => IfNull(round($obj__2[0]->GeneratedPower), RandomPower()),
        "ID" => "Solar Battery 1",
        "IsON" =>  IfNull($obj__2[0]->IsON, false),
        "Power" => IfNull(round($obj__2[0]->Power), RandomPower()),
        "RequiredPower" =>  IfNull(round($obj__2[0]->RequiredPower), RandomPower()),
    ];

    $miniSubstation1 = [
        "GeneratedPower" => IfNull(round($obj__1[2]->Childs[0]->GeneratedPower), RandomPower()),
        "ID" => "Mini Substation 1",
        "IsON" => IfNull($obj__1[2]->Childs[0]->IsON, false),
        "Power" => IfNull($obj__1[2]->Childs[0]->Power, RandomPower()),
        "RequiredPower" => IfNull(round($obj__1[2]->Childs[0]->RequiredPower), RandomPower()),
    ];

    $miniSubstation2 = [
        "GeneratedPower" => IfNull(round($obj__1[0]->Childs[0]->GeneratedPower), RandomPower()),
        "ID" => "Mini Substation 2",
        "IsON" => IfNull($obj__1[0]->Childs[0]->IsON, false),
        "Power" => IfNull(round($obj__2[0]->Power), RandomPower()),
        "RequiredPower" => IfNull(round($obj__1[0]->Childs[0]->RequiredPower), RandomPower()),
    ];

    $hospital2 = [
        "GeneratedPower" => IfNull(round($obj__1[1]->Childs[0]->GeneratedPower), RandomPower()),
        "ID" => "Hospital 2",
        "IsON" => IfNull($obj__1[1]->Childs[0]->IsON, false),
        "Power" => IfNull(round($obj__2[0]->Power), RandomPower()),
        "RequiredPower" => IfNull(round($obj__1[1]->Childs[0]->RequiredPower), RandomPower()),
    ];

    $factory2 = [
        "GeneratedPower" => IfNull(round($obj__1[1]->Childs[2]->GeneratedPower), RandomPower()),
        "ID" => "Factory 2",
        "IsON" => IfNull($obj__1[1]->Childs[2]->IsON, false),
        "Power" => IfNull(round($obj__2[0]->Power), RandomPower()),
        "RequiredPower" => IfNull(round($obj__1[1]->Childs[2]->RequiredPower), RandomPower()),
    ];

    $house1 = [
        "GeneratedPower" => IfNull(round($obj__1[0]->Childs[0]->Childs[1]->Childs[0]->GeneratedPower), RandomPower()),
        "ID" => "Microdistrict 1",
        "IsON" => IfNull($obj__1[0]->Childs[0]->Childs[1]->Childs[0]->IsON, false),
        "Power" => IfNull(round($obj__2[0]->Power), RandomPower()),
        "RequiredPower" => IfNull(round($obj__1[0]->Childs[0]->Childs[1]->Childs[0]->RequiredPower), RandomPower()),
    ];

    $house2 = [
        "GeneratedPower" => IfNull(round($obj__1[0]->Childs[0]->Childs[1]->Childs[1]->GeneratedPower), RandomPower()),
        "ID" => "Microdistrict 2",
        "IsON" => IfNull($obj__1[0]->Childs[0]->Childs[1]->Childs[1]->IsON, false),
        "Power" => IfNull(round($obj__2[0]->Power), RandomPower()),
        "RequiredPower" => IfNull(round($obj__1[0]->Childs[0]->Childs[1]->Childs[1]->RequiredPower), RandomPower()),
    ];

    $house3 = [
        "GeneratedPower" => IfNull(round($obj__1[1]->Childs[3]->GeneratedPower), RandomPower()),
        "ID" => "Microdistrict 3",
        "IsON" => IfNull($obj__1[1]->Childs[3]->IsON, false),
        "Power" => IfNull(round($obj__2[0]->Power), RandomPower()),
        "RequiredPower" => IfNull(round($obj__1[1]->Childs[3]->RequiredPower), RandomPower()),
    ];

    $house4 = [
        "GeneratedPower" => IfNull(round($obj__1[1]->Childs[4]->GeneratedPower), RandomPower()),
        "ID" => "Microdistrict 4",
        "IsON" => IfNull($obj__1[1]->Childs[4]->IsON, false),
        "Power" => IfNull(round($obj__2[0]->Power), RandomPower()),
        "RequiredPower" => IfNull(round($obj__1[1]->Childs[4]->RequiredPower), RandomPower()),
    ];

    $house5 = [
        "GeneratedPower" => IfNull(round($obj__1[1]->Childs[5]->GeneratedPower), RandomPower()),
        "ID" => "Microdistrict 5",
        "IsON" => IfNull($obj__1[1]->Childs[5]->IsON, false),
        "Power" => IfNull(round($obj__2[0]->Power), RandomPower()),
        "RequiredPower" => IfNull(round($obj__1[1]->Childs[5]->RequiredPower), RandomPower()),
    ];

    $house6 = [
        "GeneratedPower" => IfNull(round($obj__1[1]->Childs[1]->GeneratedPower), RandomPower()),
        "ID" => "Microdistrict 6",
        "IsON" => IfNull($obj__1[1]->Childs[1]->IsON, false),
        "Power" => IfNull(round($obj__2[0]->Power), RandomPower()),
        "RequiredPower" => IfNull(round($obj__1[1]->Childs[1]->RequiredPower), RandomPower()),
    ];

    $factory1 = [
        "GeneratedPower" => IfNull(round($obj__1[1]->Childs[1]->GeneratedPower), RandomPower()),
        "ID" => "Factory 1",
        "IsON" => IfNull($obj__1[1]->Childs[1]->IsON, false),
        "Power" => IfNull(round($obj__2[0]->Power), RandomPower()),
        "RequiredPower" => IfNull(round($obj__1[1]->Childs[1]->RequiredPower), RandomPower()),
    ];

    $hospital1 = [
        "GeneratedPower" => IfNull(round($obj__1[2]->Childs[0]->Childs[1]->Childs[0]->GeneratedPower), RandomPower()),
        "ID" => "Hospital 1",
        "IsON" => IfNull($obj__1[2]->Childs[0]->Childs[1]->Childs[0]->IsON, false),
        "Power" => IfNull(round($obj__2[0]->Power), RandomPower()),
        "RequiredPower" => IfNull(round($obj__1[2]->Childs[0]->Childs[1]->Childs[0]->RequiredPower), RandomPower()),
    ];

    $solarBattery2 = [
        "GeneratedPower" => IfNull(round($obj__2[4]->GeneratedPower), RandomPower()),
        "ID" => "Solar Battery 2",
        "IsON" => IfNull($obj__2[4]->IsON, false),
        "Power" => IfNull(round($obj__2[0]->Power), RandomPower()),
        "RequiredPower" => IfNull(round($obj__2[4]->RequiredPower), RandomPower()),
    ];

    $windGenerator = [
        "GeneratedPower" => IfNull(round($obj__2[2]->GeneratedPower), RandomPower()),
        "ID" => "Wind Generator",
        "IsON" => IfNull($obj__2[2]->IsON, false),
        "Power" => IfNull(round($obj__2[0]->Power), RandomPower()),
        "RequiredPower" => IfNull(round($obj__2[2]->RequiredPower), RandomPower()),
    ];

    #final array
    $final = [
        "substation" => $substation,
        "solarBattery1" => $solarBattery1,
        "miniSubstation1" => $miniSubstation1,
        "miniSubstation2" => $miniSubstation2,
        "hospital2" => $hospital2,
        "factory2" => $factory2,
        "house1" => $house1,
        "house2" => $house2,
        "house3" => $house3,
        "house4" => $house4,
        "house5" => $house5,
        "house6" => $house6,
        "factory1" => $factory1,
        "hospital1" => $hospital1,
        "solarBattery2" => $solarBattery2,
        "windGenerator" => $windGenerator,
    ];

    $final = json_encode($final);

    #
    return $final;
}

function Null($data)
{
    if (empty($data)) return "null";
    return $data;
}

function IfNull($d1, $d2)
{
    if (empty($d1)) return $d2;
    return $d1;
}

function RandomPower()
{
    return random_int(0, 100);
}
