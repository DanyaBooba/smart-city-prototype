<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />

    <title>Smart City Prototype</title>
    <meta name="description" content="Online smart city prototype">
    <meta name="Author" content="Daniil Dybka">
    <meta name="theme-color" content="#ffffff">

    <meta aframe-injected="" name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,shrink-to-fit=no,user-scalable=no,minimal-ui,viewport-fit=cover">
    <meta aframe-injected="" name="mobile-web-app-capable" content="yes">
    <meta aframe-injected="" name="theme-color" content="black">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/microsoft-signalr/3.1.3/signalr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/aframevr/aframe@d893cfacc335696c7183943eab8165100c3a6e1c/dist/aframe-master.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/donmccurdy/aframe-extras/dist/aframe-extras.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m, e, t, r, i, k, a) {
            m[i] = m[i] || function() {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            for (var j = 0; j < document.scripts.length; j++) {
                if (document.scripts[j].src === r) {
                    return;
                }
            }
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(89421065, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/89421065" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
</head>

<body>
    <?php include_once "php/listbuilds.php" ?>
    <?php $gblist = ReturnData(); ?>

    <a-scene room-manager="nav: true; startPos: 0 0 -40">

        <a-entity id="name" position="-3.833 -1.8 -2.570" rotation="0 30 0" scale="0.3 0.3 0.3" gltf-model="/models/name.glb"></a-entity>

        <a-entity id="stands2" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/stand.glb"></a-entity>
        <a-entity id="stands2" rotation="0 -1 0" animation__2=" property: rotation; to: 0 1 0; dir: alternate; dur: 4000; loop: true" animation="property: object3D.position.y; to: -1.7; dir: alternate; dur: 2000; loop: true" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/water.glb"></a-entity>

        <?php include_once "php/trees.php" ?>
        <a-entity id="stands3" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/bMinivetro.glb"></a-entity>
        <a-entity id="stands4" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/bHospital1.glb"></a-entity>
        <a-entity id="stands5" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/bHospital2.glb"></a-entity>
        <a-entity id="stands6" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/bMinisub1.glb"></a-entity>
        <a-entity id="stands7" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/bFactory2.glb"></a-entity>
        <a-entity id="stands8" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/bFactory1.glb"></a-entity>
        <a-entity id="stands9" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/bMinisub2.glb"></a-entity>
        <a-entity id="stands10" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/bLightpan2.glb"></a-entity>
        <a-entity id="stands11" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/bLightpan1.glb"></a-entity>
        <a-entity id="stands12" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/gori.glb"></a-entity>
        <a-entity id="stands14" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/bSubstation.glb"></a-entity>
        <a-entity id="stands15" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/bVetro.glb"></a-entity>
        <a-entity id="stands17" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/bHouses1.glb"></a-entity>
        <a-entity id="stands18" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/bHouses2.glb"></a-entity>
        <a-entity id="stands19" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/bMinisub1.glb"></a-entity>
        <a-entity id="stands20" position="0 -2 0" scale="0.12 0.12 0.12" gltf-model="/models/stand/trava.glb"></a-entity>

        <a-entity id="Винт Ветрогенератора 1" scale="0.12 0.12 0.12" position="-6.345 0.265 2.993" gltf-model="/models/windTurbinePropeller.glb" animation="property: rotation; to: -360 0 0; loop: true; dur: 3000; easing: linear;"></a-entity>
        <a-entity id="Винт Ветрогенератора 2" scale="0.12 0.12 0.12" position="-6.343 0.276 0" rotation="-90 0 0" gltf-model="/models/windTurbinePropeller.glb" animation="property: rotation; to: -450 0 0; loop: true; dur: 3000; easing: linear;"></a-entity>
        <a-entity id="Винт Ветрогенератора 3" scale="0.12 0.12 0.12" position="-6.333 0.266 -3.007" rotation="-180 0 0" gltf-model="/models/windTurbinePropeller.glb" animation="property: rotation; to: -540 0 0; loop: true; dur: 3000; easing: linear;"></a-entity>
        <a-entity id="Винт Мини Ветрогенератора" scale="0.12 0.12 0.12" position="12.483 -1.207 1.985" gltf-model="/models/windMiniTurbinePropeller.glb" animation="property: rotation; to: 0 -360 0; loop: true; dur: 1800; easing: linear;"></a-entity>

        <a-plane id="Плейн Подстанция [1]" onClick="clickOnName()" material="color: #000; opacity: 0.5;" position="-3.322 -1.6 -1.048" rotation="0 90 0" scale="0.72 0.63 1"></a-plane>
        <a-entity text="font: https://cdn.aframe.io/fonts/Exo2Bold.fnt; value: Substation; color: #ffffff; align: left;" id="t0__id" scale="1 1 1" position="-3.321 -1.356 -1.23" rotation="0 90 0"></a-entity>
        <a-entity text="font: https://cdn.aframe.io/fonts/Aileron-Semibold.fnt; value: Substation; color: #ffffff; align: left;" id="t0__genpow" scale="1 1 1" position="-3.321 -1.44 -1.23" rotation="0 90 0"></a-entity>
        <a-entity text="font: https://cdn.aframe.io/fonts/Aileron-Semibold.fnt; value: Active; color: #E5E5E5; align: left;" id="tconst__ison" scale="1 1 1" position="-3.321 -1.52 -1.23" rotation="0 90 0"></a-entity>

        <a-image src="/img/substation1.jpg" width="6" height="3" scale="0.12 0.12 0.12" position="-3.321 -1.76 -1.047" material="opacity: 1" rotation="0 90 0"></a-image>
        <a-image src="/img/substation1.jpg" onClick="readFile()" width="5.33" height="3" scale="0.32 0.32 0.32" position="-3.172 -1.463 1.791" material="opacity: 1" rotation="0 -45 0" id="cameraview"></a-image>

        <?php $c = 1 ?>
        <?php for ($i = 0; $i < count($gblist); $i++) : ?>

            <?php if ($gblist[$i]["click"]["on"]) : ?>
                <a-plane onClick="MainOnClick('<?php echo $gblist[$i]["click"]["jsname"] ?>', <?php echo $c ?>)" id="<?php echo $gblist[$i]["id"] ?>" material="color: #000; opacity: 0.5;" position="<?php echo $gblist[$i]["x"] . " -1.6 " . $gblist[$i]["z"] ?>" rotation="<?php echo "0 " . ((int) $gblist[$i]["rotation"] - 20) . " 0" ?>" scale="0.36 0.65 1"></a-plane>
            <?php else : ?>
                <a-plane id="<?php echo $gblist[$i]["id"] ?>" material="color: #000; opacity: 0.5;" position="<?php echo $gblist[$i]["x"] . " -1.6 " . $gblist[$i]["z"] ?>" rotation="<?php echo "0 " . ((int) $gblist[$i]["rotation"] - 20) . " 0" ?>" scale="0.36 0.65 1"></a-plane>
            <?php endif; ?>

            <a-entity text="font: https://cdn.aframe.io/fonts/Exo2Bold.fnt; value: <?php echo $gblist[$i]["id"] ?>; color: #ffffff; align: center;" id="t<?php echo $c ?>__id" scale="1 1 1" position="<?php echo $gblist[$i]["x"] . " -1.33 " . $gblist[$i]["z"] ?>" rotation="<?php echo "0 " . ((int) $gblist[$i]["rotation"] - 20) . " 0" ?>"></a-entity>
            <a-entity text="font: https://cdn.aframe.io/fonts/Aileron-Semibold.fnt; value: 0/100 kWt; color: #ffffff; align: center;" id="t<?php echo $c ?>__genpow" scale="0.85 0.85 0.85" position="<?php echo $gblist[$i]["x"] . " -1.41 " . $gblist[$i]["z"] ?>" rotation="<?php echo "0 " . ((int) $gblist[$i]["rotation"] - 20) . " 0" ?>"></a-entity>
            <a-entity text="font: https://cdn.aframe.io/fonts/Aileron-Semibold.fnt; value: 0/100 kWt; color: #ffffff; align: center;" id="t<?php echo $c ?>__reqpower" scale="0.85 0.85 0.85" position="<?php echo $gblist[$i]["x"] . " -1.48 " . $gblist[$i]["z"] ?>" rotation="<?php echo "0 " . ((int) $gblist[$i]["rotation"] - 20) . " 0" ?>"></a-entity>

            <?php if ($gblist[$i]["needactive"]) : ?>
                <a-entity text="value: State; color: #E5E5E5; align: center;" id="t<?php echo $c ?>__ison" scale="0.85 0.85 0.85" position="<?php echo $gblist[$i]["x"] . " -1.54 " . $gblist[$i]["z"] ?>" rotation="<?php echo "0 " . ((int) $gblist[$i]["rotation"] - 20) . " 0" ?>"></a-entity>
            <?php else : ?>
                <a-entity text="value: Active; color: #E5E5E5; align: center;" id="tconst__ison" scale="0.85 0.85 0.85" position="<?php echo $gblist[$i]["x"] . " -1.54 " . $gblist[$i]["z"] ?>" rotation="<?php echo "0 " . ((int) $gblist[$i]["rotation"] - 20) . " 0" ?>"></a-entity>
            <?php endif; ?>

            <a-image src="/img/active.jpg" width="3" height="3" scale="0.12 0.12 0.12" position="<?php echo $gblist[$i]["picture"]["position"]["x"] . " -1.76 " . $gblist[$i]["picture"]["position"]["z"] ?>" material="opacity: 1" rotation="<?php echo "0 " . ((int) $gblist[$i]["picture"]["rotation"] - 20) . " 0" ?>" id="im<?php echo $c ?>"></a-image>

            <?php $c += 1 ?>
        <?php endfor; ?>

        <a-sky src="/img/sky03.jpg" rotation="0 180 0"></a-sky>
        <a-entity position="0 -2 0" id="cameraRig" movement-controls="constrainToNavMesh: true; enabled: true">
            <a-entity id="cursor" camera look-controls position="0 0.8 0" rotation="0 180 0" cursor="rayOrigin: mouse" raycaster="objects: .interractible">
            </a-entity>
            <a-entity id="leftHand" hand-controls="hand: left; handModelStyle: highPoly; color: #94c6ff"></a-entity>
            <a-entity id="rightHand" hand-controls="hand: right; handModelStyle: highPoly; color: #94c6ff" laser-controls line="color: red; opacity: 0.75" raycaster="objects: .interractible"></a-entity>
            <a-entity id="choseHand"></a-entity>
        </a-entity>

    </a-scene>

    <script src="/js/jquery.min.js"></script>
    <script src="/js/index.js"></script>
</body>

</html>
