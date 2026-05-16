function MainOnClick(letname, number) {

    // id = "im" + number;
    // NewImage(id);

    let openlink = window.open("//vr.creagoo.ru/stats/jsmain.php?k=" + letname);
    setTimeout(Close(openlink), 5000);
}

// function NewImage(id) {
//     let elembyid = document.getElementById(id);
//     let link = elembyid.getAttribute('src');

//     let change = "";
//     if (link.indexOf('disable') !== -1) {
//         change = link.replace(/disable/gi, 'active');
//     } else if (link.indexOf('disable') === -1) {
//         change = link.replace(/active/gi, 'disable');
//     }

//     elembyid.setAttribute('src', change);

// }

function Close(item) {
    item.close();
}