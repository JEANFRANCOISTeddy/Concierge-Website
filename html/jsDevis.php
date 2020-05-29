<?php include 'config.php' ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script type="text/javascript" src="jspdf.min.js"></script>
    <title></title>
</head>
<body>

<?php
    if (isset($_POST['index']) && !empty($_POST['index'])) {
        $index = $_POST['index'];
    } else if (isset($_POST['lastName']) && !empty($_POST['lastName'])) {
        $lastName = $_POST['lastName'];
    } else if (isset($_POST['firstName']) && !empty($_POST['firstName'])) {
        $firstName = $_POST['firstName'];
    } else if (isset($_POST['phoneNumber']) && !empty($_POST['phoneNumber'])) {
        $phoneNumber = $_POST['phoneNumber'];
    } else if (isset($_POST['postalCode']) && !empty($_POST['postalCode'])) {
        $postalCode = $_POST['postalCode'];
    } else if (isset($_POST['city']) && !empty($_POST['city'])) {
        $city = $_POST['city'];
    } else if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        header('location:devis.php?error=empty');
        exit;
    }
?>

<input type="hidden" id="lastName" value="<?= $_POST['lastName'] ?>">
<input type="hidden" id="firstName" value="<?= $_POST['firstName'] ?>">
<input type="hidden" id="phoneNumber" value="<?= $_POST['phoneNumber'] ?>">
<input type="hidden" id="email" value="<?= $_POST['email'] ?>">
<input type="hidden" id="postalCode" value="<?= $_POST['postalCode'] ?>">
<input type="hidden" id="city" value="<?= $_POST['city'] ?>">

<?php for ($j = 0; $j < count($_POST['choix']); $j++) { ?>
    <input type="hidden" class="choix" value="<?= $_POST['choix'][$j] ?>">
<?php } ?>

<?php for ($j = 0; $j < count($_POST['choix']); $j++) {
    $req = $bdd->prepare('SELECT price FROM ' . $_POST['choix'][$j] . ' WHERE id = 1');
    $req->execute();
    $res = $req->fetch(PDO::FETCH_ASSOC); ?>
    <input type="hidden" class="price" value="<?= $res['price'] ?>">
<?php } ?>

<script type="text/javascript">

    let lastName = document.getElementById('lastName').value;
    let firstName = document.getElementById('firstName').value;
    let phoneNumber = document.getElementById('phoneNumber').value;
    let email = document.getElementById('email').value;
    let postalCode = document.getElementById('postalCode').value;
    let city = document.getElementById('city').value;

    let total = 0;
    let choix = [];

    let choice = document.getElementsByClassName('choix');
    for (var i = 0; i < choice.length; i++) {
        choix.push(choice[i].value);
    }

    let prix = [];

    let price = document.getElementsByClassName('price');
    for (var i = 0; i < price.length; i++) {
        prix.push(price[i].value);
        total += parseInt(prix[i]);
    }

    function genPDF() {

        let imgData = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAGtmlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDIgNzkuMTYwOTI0LCAyMDE3LzA3LzEzLTAxOjA2OjM5ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ0MgKFdpbmRvd3MpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAyMC0wMS0yN1QxNzo1NDowOSswMTowMCIgeG1wOk1vZGlmeURhdGU9IjIwMjAtMDEtMjhUMTM6Mjk6NDUrMDE6MDAiIHhtcDpNZXRhZGF0YURhdGU9IjIwMjAtMDEtMjhUMTM6Mjk6NDUrMDE6MDAiIGRjOmZvcm1hdD0iaW1hZ2UvcG5nIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIiBwaG90b3Nob3A6SUNDUHJvZmlsZT0ic1JHQiBJRUM2MTk2Ni0yLjEiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MjQzMGEwMzQtY2Q3ZC02ZDQ2LTgwN2ItYzU5OWM4NzM5NDM2IiB4bXBNTTpEb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6NTQ4ZWFlODYtYTM4YS02NzQ1LWEyZTEtYjdkNDdhOGFhNjcyIiB4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ9InhtcC5kaWQ6OWM4YjE0NGQtNmJmMi1kNjQwLThlNTYtMzFjNmZhYTdjOWNiIj4gPHhtcE1NOkhpc3Rvcnk+IDxyZGY6U2VxPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY3JlYXRlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo5YzhiMTQ0ZC02YmYyLWQ2NDAtOGU1Ni0zMWM2ZmFhN2M5Y2IiIHN0RXZ0OndoZW49IjIwMjAtMDEtMjdUMTc6NTQ6MDkrMDE6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDQyAoV2luZG93cykiLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmM0N2YyMGVkLWVmOWQtYjY0MC05OGMzLWFiZjJlOTRlMzAwZCIgc3RFdnQ6d2hlbj0iMjAyMC0wMS0yOFQxMzoyODo0MiswMTowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6MjQzMGEwMzQtY2Q3ZC02ZDQ2LTgwN2ItYzU5OWM4NzM5NDM2IiBzdEV2dDp3aGVuPSIyMDIwLTAxLTI4VDEzOjI5OjQ1KzAxOjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ0MgKFdpbmRvd3MpIiBzdEV2dDpjaGFuZ2VkPSIvIi8+IDwvcmRmOlNlcT4gPC94bXBNTTpIaXN0b3J5PiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Poi82IQAADMnSURBVHic7Z15XFTV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';

        let pdf = new jsPDF();
        let numberDevis = Math.round(Math.random() * 10000000);
        let date = new Date();
        let clientCode = Math.round(Math.random() * 10000);

        pdf.addImage(imgData, 'PNG', 10, 10, 50, 50);

        pdf.setDrawColor(0);
        pdf.setFillColor(255, 255, 255);
        pdf.roundedRect(140, 24, 50, 20, 3, 3, 'FD');
        pdf.setFontSize(10);
        pdf.setFontType('bold');
        pdf.text(150, 30, 'DEVIS : N°' + numberDevis);
        pdf.setFontSize(10);
        pdf.setFontType('normal');
        pdf.text(150, 35, 'Date : ' + date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear());
        pdf.setFontSize(10);
        pdf.setFontType('normal');
        pdf.text(150, 40, 'Code client : ' + clientCode + "C");
        pdf.setFont('helvetica');
        pdf.setFontType('bold');
        pdf.setFontSize(20);

        pdf.text(97, 73, 'Devis');
        pdf.setFontSize(10);

        pdf.setDrawColor(0);
        pdf.setFillColor(18, 164, 227);
        pdf.rect(30, 90, 110, 10, 'FD');
        pdf.setFontSize(15);
        pdf.text(71, 97, 'Désignation');

        pdf.setDrawColor(0);
        pdf.setFillColor(18, 164, 227);
        pdf.rect(140, 90, 50, 10, 'FD');
        pdf.setFontSize(15);
        pdf.text(160, 97, 'Prix');

        pdf.rect(30, 100, 110, 100);

        j = 107;
        for (var i = 0; i < choix.length; i++) {
            pdf.setFontType('normal');
            pdf.text(35, j, choix[i]);
            pdf.line(30, j + 2, 190, j + 2);
            j += 8;
        }

        pdf.rect(140, 100, 50, 100);

        k = 107;
        for (var i = 0; i < prix.length; i++) {
            pdf.setFontType('normal');
            pdf.text(145, k, prix[i] + ' €');
            k += 8;
        }

        pdf.setDrawColor(0);
        pdf.setFillColor(255, 255, 255);
        pdf.roundedRect(130, 210, 60, 20, 3, 3, 'FD');
        pdf.setFontSize(10);
        pdf.setFontType('bold');
        pdf.text(133, 221, 'TOTAL TTC : ' + total + ' €');

        pdf.setFontSize(12);
        pdf.setFontType('bold');
        pdf.text(30, 214, 'Récaptitulatif de vos informations : ');
        pdf.setFontType('normal');
        pdf.text(30, 224, lastName + " " + firstName);
        pdf.setFontType('normal');
        pdf.text(30, 229, city + ", " + postalCode);
        pdf.setFontType('normal');
        pdf.text(30, 234, email);

        pdf.setDrawColor(0);
        pdf.setFillColor(255, 255, 255);
        pdf.roundedRect(75, 260, 60, 20, 3, 3, 'FD');
        pdf.setFontType('bold');
        pdf.text(75, 255, 'Signature client :');

        pdf.addPage();
        pdf.save('Devis.pdf');

    }

    genPDF();

</script>
<html>

<script type="text/javascript">
    function RedirectionJavascript() {
        document.location.href = "devis.php";
    }
</script>

<body onLoad="setTimeout('RedirectionJavascript()', 10)" class="bodi">
</body>
</html>
