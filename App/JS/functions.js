function href(url)
{
    window.location.href = url;
}

function blackFontFormBaptism()
{
    $('#labelName').css('color', 'black');
    $('#labelLastname1').css('color', 'black');
    $('#labelLastname2').css('color', 'black');
}

function auxiliarWindow(type)
{
    url = "personList.php";

    name      = $("#" + type + "Name").val();
    lastname1 = $("#" + type + "Lastname1").val();
    lastname2 = $("#" + type + "Lastname2").val();

    url = url + "?name="      + name      + 
                "&lastname1=" + lastname1 + 
                "&lastname2=" + lastname2 + 
                "&type="      + type;

    if (type === 'child')
    {
        correct = true;

        if (name === '' || name === undefined)
        {
            $('#labelName').css('color', 'red');
            correct = false;
        }

        if (lastname1 === '' || lastname1 === undefined)
        {
            $('#labelLastname1').css('color', 'red');
            correct = false;
        }

        if (lastname2 === '' || lastname2 === undefined)
        {
            $('#labelLastname2').css('color', 'red');
            correct = false;
        }

        if (correct)
        {
            window.open(url, "_blanck", "width=300, height=600, scrollbars=yes");
        }
    }
    else
    {
        window.open(url, "_blanck", "width=300, height=600, scrollbars=yes");
    }
}

function loadSort(page, id)
{
    if (page == 'userMenu.php')
    {
        var sortType = 0;
        var target   = "";

        if (document.getElementById('sortType') !== null)
        {
            sortType = document.getElementById('sortType').selectedIndex;;
        }

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id";
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=username";
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=nameChurch";
        }

        window.location.href = target;
    }
    else if (page == 'proofMenu.php')
    {
        var sortType = 0;
        var target   = "";

        if (document.getElementById('sortType') !== null)
        {
            sortType = document.getElementById('sortType').selectedIndex;;
        }

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id";
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=nameChild";
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=nameChurch";
        }

        window.location.href = target;
    }
    else if (page == 'marriageMenu.php')
    {
        var sortType = 0;
        var target   = "";

        if (document.getElementById('sortType') !== null)
        {
            sortType = document.getElementById('sortType').selectedIndex;;
        }

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id";
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=nameBoy";
        }
        else if (sortType == 2)
        {
            target = page + "?page=0&sort=nameGirl";
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=church";
        }

        window.location.href = target;
    }
    else if (page == 'communionMenu.php' || page == 'confirmationMenu.php')
    {
        var sortType = 0;
        var target   = "";

        if (document.getElementById('sortType') !== null)
        {
            sortType = document.getElementById('sortType').selectedIndex;;
        }

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id";
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=nameChild";
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=nameChurch";
        }

        window.location.href = target;
    }
    else if (page == 'baptismMenu.php' || page == 'defuntionMenu.php')
    {
        var sortType = 0;
        var target   = "";

        if (document.getElementById('sortType') !== null)
        {
            sortType = document.getElementById('sortType').selectedIndex;;
        }

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id";
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=nameChild";
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=nameChurch";
        }

        window.location.href = target;
    }
    else if (page == 'churchMenu.php' || page == 'rectorChurchRelationMenu.php')
    {
        var sortType = 0;
        var target   = "";

        if (document.getElementById('sortType') !== null)
        {
            sortType = document.getElementById('sortType').selectedIndex;;
        }

        if (!(id === undefined || id === ""))
        {
            kid = "&id=" + id;
        }
        else
        {
            kid = "";
        }

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id" + kid;
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=name" + kid;
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=address" + kid;
        }

        window.location.href = target;
    }
    else if (page == 'rectorMenu.php' || page == 'churchRectorRelationMenu.php')
    {
        var sortType = 0;
        var target   = "";
        var kid      = "";

        if (document.getElementById('sortType') !== null)
        {
            sortType = document.getElementById('sortType').selectedIndex;;
        }

        if (!(id === undefined || id === ""))
        {
            kid = "&id=" + id;
        }

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id" + kid;
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=name" + kid;
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=church" + kid;
        }

        console.log(target);

        window.location.href = target;
    }
}

function simpleSearch(page)
{
    if (page == 'userMenu.php')
    {
        var sortType = 0;
        var keyword  = document.getElementById('inputSimple').value;
        var target   = "";

        if (document.getElementById('sortType') !== null)
        {
            sortType = document.getElementById('sortType').selectedIndex;;
        }

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id&keyword=" + keyword;
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=username&keyword=" + keyword;
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=nameChurch&keyword=" + keyword;
        }   

        window.location.href = target;
    }
    else if (page == 'proofMenu.php')
    {
        var sortType = 0;
        var keyword  = document.getElementById('inputSimple').value;
        var target   = "";

        if (document.getElementById('sortType') !== null)
        {
            sortType = document.getElementById('sortType').selectedIndex;;
        }

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id&keyword=" + keyword;
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=nameChild&keyword=" + keyword;
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=nameChurch&keyword=" + keyword;
        }   

        window.location.href = target;
    }
    else if (page == 'marriageMenu.php')
    {
        var sortType = 0;
        var keyword  = document.getElementById('inputSimple').value;
        var target   = "";

        if (document.getElementById('sortType') !== null)
        {
            sortType = document.getElementById('sortType').selectedIndex;;
        }

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id&keyword=" + keyword;
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=nameBoy&keyword=" + keyword;
        }
        else if (sortType == 2)
        {
            target = page + "?page=0&sort=nameGirl&keyword=" + keyword;
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=church&keyword=" + keyword;
        }

        window.location.href = target;
    }
    else if (page == 'communionMenu.php' || page == 'confirmationMenu.php')
    {
        var sortType = 0;
        var keyword  = document.getElementById('inputSimple').value;
        var target   = "";

        if (document.getElementById('sortType') !== null)
        {
            sortType = document.getElementById('sortType').selectedIndex;;
        }

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id&keyword=" + keyword;
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=nameChild&keyword=" + keyword;
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=nameChurch&keyword=" + keyword;
        }   

        window.location.href = target;
    }
    else if (page == 'baptismMenu.php')
    {
        var sortType = 0;
        var keyword  = document.getElementById('inputSimple').value;
        var target   = "";

        if (document.getElementById('sortType') !== null)
        {
            sortType = document.getElementById('sortType').selectedIndex;;
        }

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id&keyword=" + keyword;
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=nameChild&keyword=" + keyword;
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=nameChurch&keyword=" + keyword;
        }   

        window.location.href = target;
    }
    else if (page == 'defuntionMenu.php')
    {
        var sortType = 0;
        var keyword  = document.getElementById('inputSimple').value;
        var target   = "";

        if (document.getElementById('sortType') !== null)
        {
            sortType = document.getElementById('sortType').selectedIndex;;
        }

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id&keyword=" + keyword;
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=nameChild&keyword=" + keyword;
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=nameChurch&keyword=" + keyword;
        }   

        window.location.href = target;
    }
    else if (page == 'churchMenu.php')
    {
        var sortType = 0;
        var keyword  = document.getElementById('inputSimple').value;
        var target   = "";

        if (document.getElementById('sortType') !== null)
        {
            sortType = document.getElementById('sortType').selectedIndex;;
        }

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id&keyword=" + keyword;
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=name&keyword=" + keyword;
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=address&keyword=" + keyword;
        }   

        window.location.href = target;
    }
    else if (page == 'rectorMenu.php')
    {
        var sortType = 0;
        var keyword  = document.getElementById('inputSimple').value;
        var target   = "";

        if (document.getElementById('sortType') !== null)
        {
            sortType = document.getElementById('sortType').selectedIndex;;
        }

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id&keyword=" + keyword;
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=name&keyword=" + keyword;
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=church&keyword=" + keyword;
        }   

        window.location.href = target;
    }
}

function advancedSearch(page)
{
    if (page == 'userMenu.php')
    {
        var inputId        = $('#inputId').val();
        var inputUsername  = $('#inputUsername').val();
        var inputChurch    = $('#inputChurch').val();

        var selectType     = document.getElementById("selectType").selectedIndex.toString();
        var onlineCheck    = document.getElementById("inputOnline").checked.toString();
        var sortType = "0";

        if (document.getElementById('sortType') !== null)
        {
            var sortType = document.getElementById('sortType').selectedIndex;;
        }

        var target   = "";

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id&";
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=username&";
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=nameChurch&";
        }   

        target = target +   "&kid"            + inputId         +
                            "&kusername="     + inputUsername   + 
                            "&ktype="         + selectType      +
                            "&konlineCheck="  + onlineCheck     +
                            "&kchurch="       + inputChurch;

        window.location.href = target;
    }
    else if (page == 'proofMenu.php')
    {
        var inputChildNames      = $('#inputChildNames').val();
        var inputChildLastname1  = $('#inputChildLastname1').val();
        var inputChildLastname2  = $('#inputChildLastname2').val();
        var inputFatherNames     = $('#inputFatherNames').val();
        var inputFatherLastname1 = $('#inputFatherLastname1').val();
        var inputFatherLastname2 = $('#inputFatherLastname2').val();
        var inputMotherNames     = $('#inputMotherNames').val();
        var inputMotherLastname1 = $('#inputMotherLastname1').val();
        var inputMotherLastname2 = $('#inputMotherLastname2').val();
        var inputChurch          = $('#inputChurch').val();
        var selectType           = document.getElementById("typeProof").selectedIndex.toString();
        var sortType = "0";

        if (document.getElementById('sortType') !== null)
        {
            var sortType = document.getElementById('sortType').selectedIndex;;
        }

        var target   = "";

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id&";
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=nameChild&";
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=nameChurch&";
        }   

        target = target +   "&kid=0"          +
                            "&knamec="        + inputChildNames      + 
                            "&klastname1c="   + inputChildLastname1  +
                            "&klastname2c="   + inputChildLastname2  +
                            "&knamef="        + inputFatherNames     +
                            "&klastname1f="   + inputFatherLastname1 +
                            "&klastname2f="   + inputFatherLastname2 +
                            "&knamem="        + inputMotherNames     +
                            "&klastname1m="   + inputMotherLastname1 +
                            "&klastname2m="   + inputMotherLastname2 +
                            "&kchurch="       + inputChurch          +
                            "&ktype="         + selectType;

        window.location.href = target;
    }
    else if (page == 'marriageMenu.php')
    {
        var inputId                  = $('#inputId').val();
        var inputCelebrationDate     = $('#inputCelebrationDate').val();
        var inputBoyfriendNames      = $('#inputBoyfriendNames').val();
        var inputBoyfriendLastname1  = $('#inputBoyfriendLastname1').val();
        var inputBoyfriendLastname2  = $('#inputBoyfriendLastname2').val();
        var inputGirlfriendNames     = $('#inputGirlfriendNames').val();
        var inputGirlfriendLastname1 = $('#inputGirlfriendLastname1').val();
        var inputGirlfriendLastname2 = $('#inputGirlfriendLastname2').val();
        var inputChurch              = $('#inputChurch').val();
        var inputBook                = $('#inputBook').val();
        var inputPage                = $('#inputPage').val();
        var inputNumber              = $('#inputNumber').val();
        var sortType = "0";

        if (document.getElementById('sortType') !== null)
        {
            var sortType = document.getElementById('sortType').selectedIndex;;
        }

        var target   = "";

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id&";
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=nameBoy&";
        }
        else if (sortType == 2)
        {
            target = page + "?page=0&sort=nameGirl&";
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=church&";
        }

        target = target +   "kid="            + inputId                  +
                            "&kcelebration="  + inputCelebrationDate     +
                            "&knameb="        + inputBoyfriendNames      + 
                            "&klastname1b="   + inputBoyfriendLastname1  +
                            "&klastname2b="   + inputBoyfriendLastname2  +
                            "&knameg="        + inputGirlfriendNames     +
                            "&klastname1g="   + inputGirlfriendLastname1 +
                            "&klastname2g="   + inputGirlfriendLastname2 +
                            "&kchurch="       + inputChurch              +
                            "&kbook="         + inputBook                +
                            "&knumber="       + inputNumber              +
                            "&kpape="         + inputPage;

        window.location.href = target;
    }
    else if (page == 'communionMenu.php' || page == 'confirmationMenu.php')
    {
        var inputId              = $('#inputId').val();
        var inputCelebrationDate = $('#inputCelebrationDate').val();
        var inputChildNames      = $('#inputChildNames').val();
        var inputChildLastname1  = $('#inputChildLastname1').val();
        var inputChildLastname2  = $('#inputChildLastname2').val();
        var inputFatherNames     = $('#inputFatherNames').val();
        var inputFatherLastname1 = $('#inputFatherLastname1').val();
        var inputFatherLastname2 = $('#inputFatherLastname2').val();
        var inputMotherNames     = $('#inputMotherNames').val();
        var inputMotherLastname1 = $('#inputMotherLastname1').val();
        var inputMotherLastname2 = $('#inputMotherLastname2').val();
        var inputChurch          = $('#inputChurch').val();
        var inputBook            = $('#inputBook').val();
        var inputPage            = $('#inputPage').val();
        var inputNumber          = $('#inputNumber').val();
        var sortType = "0";

        if (document.getElementById('sortType') !== null)
        {
            var sortType = document.getElementById('sortType').selectedIndex;;
        }

        var target   = "";

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id&";
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=nameChild&";
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=nameChurch&";
        }   

        target = target +   "kid=" + inputId +
                            "&kcelebration="  + inputCelebrationDate +
                            "&knamec="        + inputChildNames      + 
                            "&klastname1c="   + inputChildLastname1  +
                            "&klastname2c="   + inputChildLastname2  +
                            "&knamef="        + inputFatherNames     +
                            "&klastname1f="   + inputFatherLastname1 +
                            "&klastname2f="   + inputFatherLastname2 +
                            "&knamem="        + inputMotherNames     +
                            "&klastname1m="   + inputMotherLastname1 +
                            "&klastname2m="   + inputMotherLastname2 +
                            "&kchurch="       + inputChurch          +
                            "&kbook="         + inputBook            +
                            "&knumber="       + inputNumber          +
                            "&kpape="         + inputPage;

        window.location.href = target;
    }
    else if (page == 'baptismMenu.php')
    {
        var inputId              = $('#inputId').val();
        var inputCelebrationDate = $('#inputCelebrationDate').val();
        var inputBornDate        = $('#inputBornDate').val();
        var inputBornPlace       = $('#inputBornPlace').val();
        var inputChildNames      = $('#inputChildNames').val();
        var inputChildLastname1  = $('#inputChildLastname1').val();
        var inputChildLastname2  = $('#inputChildLastname2').val();
        var inputFatherNames     = $('#inputFatherNames').val();
        var inputFatherLastname1 = $('#inputFatherLastname1').val();
        var inputFatherLastname2 = $('#inputFatherLastname2').val();
        var inputMotherNames     = $('#inputMotherNames').val();
        var inputMotherLastname1 = $('#inputMotherLastname1').val();
        var inputMotherLastname2 = $('#inputMotherLastname2').val();
        var inputChurch          = $('#inputChurch').val();
        var inputBook            = $('#inputBook').val();
        var inputPage            = $('#inputPage').val();
        var inputNumber          = $('#inputNumber').val();
        var sortType = "0";

        if (document.getElementById('sortType') !== null)
        {
            var sortType = document.getElementById('sortType').selectedIndex;;
        }

        var target   = "";

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id&";
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=nameChild&";
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=nameChurch&";
        }   

        target = target +   "kid=" + inputId +
                            "&kcelebration="  + inputCelebrationDate +
                            "&kbornp="        + inputBornPlace       +
                            "&kbornd="        + inputBornDate        +
                            "&knamec="        + inputChildNames      + 
                            "&klastname1c="   + inputChildLastname1  +
                            "&klastname2c="   + inputChildLastname2  +
                            "&knamef="        + inputFatherNames     +
                            "&klastname1f="   + inputFatherLastname1 +
                            "&klastname2f="   + inputFatherLastname2 +
                            "&knamem="        + inputMotherNames     +
                            "&klastname1m="   + inputMotherLastname1 +
                            "&klastname2m="   + inputMotherLastname2 +
                            "&kchurch="       + inputChurch          +
                            "&kbook="         + inputBook            +
                            "&knumber="       + inputNumber          +
                            "&kpape="         + inputPage;

        window.location.href = target;
    }
    else if (page == 'defuntionMenu.php')
    {
        var inputId              = $('#inputId').val();
        var inputCelebrationDate = $('#inputCelebrationDate').val();
        var inputChildNames      = $('#inputOwnerNames').val();
        var inputChildLastname1  = $('#inputOwnerLastname1').val();
        var inputChildLastname2  = $('#inputOwnerLastname2').val();
        var inputChurch          = $('#inputChurch').val();
        var sortType = "0";

        if (document.getElementById('sortType') !== null)
        {
            var sortType = document.getElementById('sortType').selectedIndex;;
        }

        var target   = "";

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id&";
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=nameChild&";
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=nameChurch&";
        }   

        target = target +   "kid=" + inputId +
                            "&kcelebration="  + inputCelebrationDate +
                            "&knamec="        + inputChildNames      + 
                            "&klastname1c="   + inputChildLastname1  +
                            "&klastname2c="   + inputChildLastname2  +
                            "&kchurch="       + inputChurch;

        window.location.href = target;
    }
    else if (page == 'churchMenu.php')
    {
        var inputId          = $('#inputId').val();
        var inputName        = $('#inputName').val();
        var inputType        = $('#inputType').val();
        var inputCode        = $('#inputCode').val();
        var inputAddress     = $('#inputAddress').val();
        var inputColony      = $('#inputColony').val();
        var inputPostalCode  = $('#inputPostalCode').val();
        var inputPhonenumber = $('#inputPhonenumber').val();
        var inputDean        = $('#inputDean').val();
        var inputVicar       = $('#inputVicar').val();
        var inputCity        = $('#inputCity').val();
        var sortType = "0";

        if (document.getElementById('sortType') !== null)
        {
            var sortType = document.getElementById('sortType').selectedIndex;;
        }

        var target   = "";

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id&";
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=nameChild&";
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=nameChurch&";
        }   

        target = target +   "kid=" + inputId +
                            "&kName="        + inputName        +
                            "&kType="        + inputType        +
                            "&kCode="        + inputCode        +
                            "&kAddress="     + inputAddress     +
                            "&kColony="      + inputColony      +
                            "&kPostalCode="  + inputPostalCode  +
                            "&kPhonenumber=" + inputPhonenumber +
                            "&kDean="        + inputDean        +
                            "&kVicar="       + inputVicar       +
                            "&kCity="        + inputCity;

        window.location.href = target;
    }
    else if (page == 'rectorMenu.php')
    {
        var inputId           = $('#inputId').val();
        var inputName         = $('#inputName').val();
        var inputLastname1    = $('#inputLastname1').val();
        var inputLastname2    = $('#inputLastname2').val();
        var inputActualChurch = $('#inputActualChurch').val();
        var inputType         = $('#inputType').val();
        var inputStatus       = $('#inputStatus').val();
        var inputPosition     = $('#inputPosition').val();
        var sortType = "0";
        var target   = "";

        if (document.getElementById('sortType') !== null)
        {
            var sortType = document.getElementById('sortType').selectedIndex;;
        }

        if (sortType == 0)
        {
            target = page + "?page=0&sort=id&";
        }
        else if (sortType == 1)
        {
            target = page + "?page=0&sort=name&";
        }
        else //Asumme 2
        {
            target = page + "?page=0&sort=church&";
        }   

        target = target +   "kid=" + inputId +
                            "&kname="        + inputName         + 
                            "&klastname1="   + inputLastname1    +
                            "&klastname2="   + inputLastname2    +
                            "&kchurch="      + inputActualChurch +
                            "&ktype="        + inputType         +
                            "&kstatus="      + inputStatus       +
                            "&kposition="    + inputPosition;

        window.location.href = target;
    }
}

function nextPage(state, number)
{
    url = String(window.location);
    
    pageBegin = -1;

    for (var i = 0; i < url.length - 5; i++) 
    {
        if (url.substring(i, i+5) == 'page=')
        {
            pageBegin = i;
            break;
        }
    }

    if (pageBegin == -1) //page 0
    {
        if (state === 'true' || state === 'false')
        {
            if (url.indexOf('?') == -1)
            {
                url = url + "?page=1";
            }
            else
            {
                url = url + "&page=1";
            }
        }
        else
        {
            if (url.indexOf('?') == -1)
            {
                url = url + "?page=" + number;
            }
            else
            {
                url = url + "&page=" + number;
            }   
        }
    }
    else
    {
        pageEnd = -1;

        for (i = pageBegin; i < url.length; i++)
        {
            if (url[i] == '&')
            {
                pageEnd = i;
                break;
            }
        }

        if (pageEnd == -1)
        {
            pageEnd = url.length;
        }

        urlPrev = url.substring(pageBegin, pageEnd);

        if (state == 'true')
        {
            urlNext = "page=" + (parseInt(urlPrev.substring(5)) + 1);
        }
        else if (state == 'set')
        {
            urlNext = "page=" + number;
        }
        else
        {
            urlNext = "page=" + (parseInt(urlPrev.substring(5)) - 1);
        }

        url = url.replace(urlPrev, urlNext);
    }

    window.location.href = url;
}

function inputNumeric(id)
{
    obj =  document.getElementById(id);

    cad = obj.value;

    var letras = '01234567890+-';

    for (var i = 0; i < cad.length; i++) 
    {
        if (letras.indexOf(cad[i]) === -1)
        {
            cad = cad.substring(0, i) + cad.substring(i+1, i+2);
            i--;
        }
    }
    
    obj.value = cad;
}

function inputNames(id)
{
    obj =  document.getElementById(id);
    cad = obj.value;

    var letrasM = 'ABCDEFGHIJKLMNOPQRSTUVWXYZÑÁÉÍÓÚŮ .';
    var letrasm = 'abcdefghijklmnopqrstuvwxyzñáéíóúů .';

    while (cad[0] == " ")
    {
        cad = cad.substring(1);
    }

    if (cad.length > 1) //put the upper at begin
    {
        if (letrasM.indexOf(cad[0]) == -1)
        {
            cad = cad.substring(0,1).toUpperCase() + cad.substring(1).toLowerCase();
        }
    }

    for (var i = cad.length -2; i >= 0; i--) //validate the space + upper
    {
        if (cad[i] == " ")
        {
            cad = cad.substring(0, i+1)+cad.substring(i+1, i+2).toUpperCase() + cad.substring(i+2);
        }
    }

    if (cad[cad.length-2] == " ") //begin of name
    {
        if (letrasM.indexOf(cad[cad.length-1]) == -1)
        {
            if (letrasm.indexOf(cad[cad.length-1]) == -1)
            {
                cad = cad.substring(0, cad.length - 1);
            }
            else
            {
                cad = cad.substring(0, cad.length-1) + cad[cad.length-1].toUpperCase();
            }
        }
    }
    else
    {
        if (letrasM.indexOf(cad[cad.length-1]) == -1)
        {
            if (letrasm.indexOf(cad[cad.length-1]) == -1) //middle letter
            {
                cad = cad.substring(0, cad.length - 1);
            }
        }
        else
        {
            cad = cad.substring(0, cad.length - 1) + cad.substring(cad.length-1).toLowerCase();        
        }
    }
    
    if (cad.length === 1)
    {
        cad = cad.toUpperCase();
    }

    obj.value = cad;
}

function inputCharacter(id)
{
    obj =  document.getElementById(id);

    cad = obj.value;

    var letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZÑÁÉÍÓÚŮ abcdefghijklmnopqrstuvwxyzñáéíóúů01234567890#$%&/.,!?';

    if (letras.indexOf(cad[cad.length - 1]) == -1)
    {
        cad = cad.substring(0, cad.length - 1);
    }
    
    obj.value = cad;
}

function checkNiche()
{
    var check = document.getElementById('inputNiche');

    if (check.checked == true)
    {
        hiddenElement('panelNiche', 'false');
    }
    else
    {
        hiddenElement('panelNiche', 'true');
    }
}

function checkCrypt()
{
    var check = document.getElementById('inputCrypt');

    if (check.checked == true)
    {
        hiddenElement('panelCrypt', 'false');
    }
    else
    {
        hiddenElement('panelCrypt', 'true');
    }
}

function changeParent(id, inner)
{
    $('#insideRector').html('<span class="filter-option pull-left">' + inner + '</span>');
    $('#insideRector').attr('value', id);
}

function hiddenElement(id, status, type)
{
    if (status === "true")
    {
        $("#" + id).css("display", "none");
    }
    else
    {
        if (type === undefined)
        {
            $("#" + id).css("display", "block");
        }
        else
        {
            $("#" + id).css("display", type);
        }        
    }
}

function reziseTable()
{
    page = String(window.location);

    if (page.indexOf('Menu') != -1)
    {
        var buttonSearchInner = '<img src="icons/search.png" height="25px">';

        if (screen.width <= 800)
        {
            paddC = String($("#simpleSearch").css('padding-left'));
            paddC = paddC.substring(0, paddC.indexOf('px')); 

            widthA = $("#main").width();
            widthB = $("#panel-body").width();
            widthC = $("#simpleSearch").width() - 2*paddC;

            if ($('#simpleSearch').css('display') == 'none')
            {
                paddC = String($("#advancedSearch").css('padding-left'));
                paddC = paddC.substring(0, paddC.indexOf('px')); 

                widthC = $("#advancedSearch").width() - 2*paddC;
            }

            $("#table1").width(widthC + 'px');
        }
        else
        {
            navigatorName = navigator.userAgent.toLowerCase();
            numberMagic   = 0;

            if (navigatorName.indexOf("firefox") != -1)
            {
                numberMagic = 0;
            }
            else if (navigatorName == "chrome" != -1)
            {
                numberMagic = 30;
            }

            widthA = $("#main").width();
            widthB = $("#panel-body").width();
            widthC = $("#simpleSearch").width();

            if ($('#simpleSearch').css('display') == 'none')
            {
                widthC = $("#advancedSearch").width();
            }

            $("#table1").width(widthC - numberMagic + 'px');
            $("#no-more-tables").css("padding-left", (widthA - widthB)/2 + "px");
            $("#no-more-tables").css("padding-right", (widthA - widthB)/2 + "px");
        }
    }
}

function loadCalendar()
{
    url = String(window.location);

    if (url.indexOf('baptismMenu') != -1)
    {
        $("#inputCelebrationDate").datepicker({ dateFormat: "dd/mm/yy" });
        $("#inputBornDate").datepicker({ dateFormat: "dd/mm/yy" });
    }
    else
    {
        if (url.indexOf('baptism') != -1)
        {
            $("#childBornDate").datepicker({ dateFormat: "dd/mm/yy" });
            $("#childBaptismDate").datepicker({ dateFormat: "dd/mm/yy" });
            $('.selectpicker').selectpicker();
        }
        else 
        {
            if (url.indexOf('communionMenu') != -1 || url.indexOf('confirmationMenu') != -1)
            {
                $("#inputCelebrationDate").datepicker({ dateFormat: "dd/mm/yy" });
            }
            else
            {
                if (url.indexOf('communion') != -1)
                {
                    $("#childCommunionDate").datepicker({ dateFormat: "dd/mm/yy" });
                    $('.selectpicker').selectpicker();
                }
                else if (url.indexOf('confirmation') != -1)
                {
                    $("#childConfirmationDate").datepicker({ dateFormat: "dd/mm/yy" });
                    $("#baptismDate").datepicker({ dateFormat: "dd/mm/yy" });
                    $('.selectpicker').selectpicker();   
                }
                else if (url.indexOf('marriage') != -1)
                {
                    $("#marriageDate").datepicker({ dateFormat: "dd/mm/yy" });
                    $('.selectpicker').selectpicker();   
                }
                else if (url.indexOf('defuntionMenu') != -1)
                {
                    $("#inputCelebrationDate").datepicker({ dateFormat: "dd/mm/yy" });
                    $('.selectpicker').selectpicker();   
                }
                else if (url.indexOf('defuntion') != -1)
                {
                    $("#childDefuntionDate").datepicker({ dateFormat: "dd/mm/yy" });
                    $('.selectpicker').selectpicker();   
                }
            }
        }
    }
}
