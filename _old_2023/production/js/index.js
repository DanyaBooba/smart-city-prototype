// обновление интерфейса локации

// 15.01.2023

let interval = 300;
let objCount = 16;

let main_array = [];
let jsonFile = '/json/index.txt';

$(function() {
  setInterval(function() {
    $.ajax({
      url: jsonFile,
      dataType: 'json'
    }).done(function(data) {

      if (data === null) {
        console.log('File is empty');
      }
      else if (data !== null) {
        GetBuilds(data);
        for(var i = 0; i < main_array.length; i++){
          UpdateInterface(i);
        }
      }

      UpdateCameraImage();
    });
  }, interval);

  function GetBuilds(data){
    substation = data["substation"];
    solarBattery1 = data["solarBattery1"];
    solarBattery2 = data["solarBattery2"];
    miniSubstation1 = data["miniSubstation1"];
    miniSubstation2 = data["miniSubstation2"];
    hospital1 = data["hospital1"];
    hospital2 = data["hospital2"];
    factory1 = data["factory1"];
    factory2 = data["factory2"];
    house1 = data["house1"];
    house2 = data["house2"];
    house3 = data["house3"];
    house4 = data["house4"];
    house5 = data["house5"];
    house6 = data["house6"];
    windGenerator = data["windGenerator"];

    main_array = [];
    main_array.push(substation);
    main_array.push(solarBattery1);
    main_array.push(miniSubstation1);
    main_array.push(miniSubstation2);
    main_array.push(hospital2);
    main_array.push(factory2);
    main_array.push(house1);
    main_array.push(house2);
    main_array.push(house3);
    main_array.push(house4);
    main_array.push(house5);
    main_array.push(house6);
    main_array.push(factory1);
    main_array.push(hospital1);
    main_array.push(solarBattery2);
    main_array.push(windGenerator);
  }

  function UpdateInterface(i){

    var item = main_array[i];
    var activeItem = '#t' + i;

    var id = $(activeItem + '__id');
    var ison = $(activeItem + '__ison');
    var genpower = $(activeItem + '__genpow');
    var reqpower = $(activeItem + '__reqpower');
    var imageLink = $('#im' + i);

    if(id.length){
      id[0].setAttribute('text', { value: HumansNamesBuilds(item["ID"]) });
    }

    if(ison.length){
      ison[0].setAttribute('text', { value: InformationOfStateBuild(item["IsON"]) });
      if (item["IsON"] === true) { ison[0].setAttribute('text', { color: '#2BFF3B' }); }
      if (item["IsON"] === false) { ison[0].setAttribute('text', { color: '#FF2B2B' }); }
    }

    if (genpower.length) {
      if (item["GeneratedPower"] >= 100) {
        genpower[0].setAttribute('text', { value: Math.round(item["GeneratedPower"]) + ' kWt' });
      }
      else {
        genpower[0].setAttribute('text', { value: Math.round(item["GeneratedPower"]) + '/100 kWt' });
      }
    }

    if(reqpower.length){
      if (item["RequiredPower"] >= 100) {
        reqpower[0].setAttribute('text', { value: Math.round(item["RequiredPower"]) + ' kWt' });
      }
      else {
        reqpower[0].setAttribute('text', { value: Math.round(item["RequiredPower"]) + '/100 kWt' });
      }
    }

    if(imageLink.length){
      var nameImage = GetNameBuildByIndex(i);
      if (GetStaticBoolInformation(i) === true) {
        var stateImage = "_active";
        if(main_array[i]["IsON"] === false) { stateImage = "_disable"; }
        nameImage += stateImage;
      }
      imageLink[0].setAttribute('src', '/img/' + nameImage + '.jpg');
    }

  }

  function GetNameBuildByIndex(i) {
    if (i === 1) { return "solarbattery1" }
    if (i === 2) { return "minisubstation1" }
    if (i === 3) { return "minisubstation2" }
    if (i === 4) { return "hospital2" }
    if (i === 5) { return "factory2" }
    if (i === 6) { return "md1" }
    if (i === 7) { return "md2" }
    if (i === 8) { return "md3" }
    if (i === 9) { return "md4" }
    if (i === 10) { return "md5" }
    if (i === 11) { return "md6" }
    if (i === 12) { return "factory1" }
    if (i === 13) { return "hospital1" }
    if (i === 14) { return "solarbattery2" }
    if (i === 15) { return "windgenerator" }
    return "null";
  }

  function GetStaticBoolInformation(i) {
    if(i === 1 || i === 2 || i === 3 || i === 14 || i === 15) {
      return false;
    }
    return true;
  }

  function HumansNamesBuilds(key) {
    if (key === "Substation") { return "Substation" }
    if (key === "Mini Substation 1") { return "Mini Sub. No. 1" }
    if (key === "Mini Substation 2") { return "Mini Sub. No. 2" }
    if (key === "Wind Generator") { return "Wind Generator" }
    if (key === "Solar Battery 1") { return "Solar Batt. No. 1" }
    if (key === "Solar Battery 2") { return "Solar Batt. No. 2" }
    if (key === "Microdistrict 1") { return "MD No. 1" }
    if (key === "Microdistrict 2") { return "MD No. 2" }
    if (key === "Microdistrict 3") { return "MD No. 3" }
    if (key === "Microdistrict 4") { return "MD No. 4" }
    if (key === "Microdistrict 5") { return "MD No. 5" }
    if (key === "Microdistrict 6") { return "MD No. 6" }
    if (key === "Hospital 1") { return "Hospital No. 1" }
    if (key === "Hospital 2") { return "Hospital No. 2" }
    if (key === "Factory 1") { return "Factory No. 1" }
    if (key === "Factory 2") { return "Factory No. 2" }
    return "null";
  }

  function InformationOfStateBuild(value){
    if (value === false) { return "Disable"; }
    if (value === true) { return "Active"; }
    return "Disable";
  }

  function UpdateCameraImage()
  {
    var rawFile = new XMLHttpRequest();
    rawFile.open("GET", "/img/camera/ver.txt", false);
    rawFile.onreadystatechange = function ()
    {
        if(rawFile.readyState === 4)
        {
            if(rawFile.status === 200 || rawFile.status == 0)
            {
                var number = rawFile.responseText;
                $('#cameraview')[0].setAttribute('src', '/img/camera/camera_' + number + '.jpg');

                console.log('readfile: ' + number);
            }
        }
    }
    rawFile.send(null);
  }

});
