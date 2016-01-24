var lang;

$( window ).load(function() 
{
    header = "Bienvenido";
    
    if (document.getElementById("headerLanguage") !== null)
    {
        header = document.getElementById("headerLanguage").innerHTML;    
    }    

    if (header.indexOf("Bienvenido") !== -1)
    {
        lang = 'es';
    }
    else
    {
        lang = 'en';
    }
});

function validateCrypt()
{
    churchVal = $("#church").val();

    if (churchVal !== '')
    {
        $.ajax
        ({
            data: {
                    'churchName' : churchVal
                  },

            type: "POST",
            url: '../JS/Ajax/churchNiche.php',
        })
        .done(function( data, textStatus, jqXHR ) 
        {
            if (data.indexOf("KO") === -1)
            {
                $("#cryptlabel").css("display", "block");
                $("#crypts").css("display", "block");
                $("#panelCrypt").css("display", "none");
                document.getElementById('inputCrypt').checked = false;
            }
            else //OK
            {
                $("#cryptlabel").css("display", "none");
                $("#crypts").css("display", "none");
                $("#panelCrypt").css("display", "none");
                document.getElementById('inputCrypt').checked = false; 
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) 
        {
            alert(getLangMsj("Error Same Data Invalid"));
        });
    }    
}

function normalBackground()
{
    $('#txtloginu').css('color', 'white');
    $('#txtloginp').css('color', 'white');
    $('#txtUser').css('background-color', 'rgba(255,255,255,0.5)');
    $('#txtPassword').css('background-color', 'rgba(255,255,255,0.5)');
    $('#txtUser').css('color', 'black');
    $('#txtPassword').css('color', 'black');
    $('#txtUser').attr('placeholder', 'Username');
    $('#txtPassword').attr('placeholder', '••••••••');
}

function isEnter(evento)
{
    if (evento.keyCode == 13)
    {
        validateUser();
    }
}

function getLangMsj(msj)
{   
    if (lang == 'es')
    {
        if (msj === "Error Existing Church")
        {
            return "Error, Iglesia existente";
        }
        else if (msj === "Sucess Save")
        {
            return "Guardado Exitoso";
        }
        else if (msj === "Error Updating Church, Same Data")
        {
            return "Error actualizando Iglesia, Mismos datos";
        }
        else if (msj === "Error Existing Office")
        {
            return "Error, Oficina Existente";
        }
        else if (msj === "Error Existing Vicar")
        {
            return "Error, Vicaria Existente";
        }
        else if (msj === "Error Existing Dean")
        {
            return "Error, Decanato Existente";
        }
        else if (msj === "Error Existing City")
        {
            return "Error, Ciudad Existente";
        }
        else if (msj === "Error Existing Rector")
        {
            return "Error, Sacerdote Existente";
        }
        else if (msj === "Error Same Rector Data")
        {
            return "Error, Mismos Datos de Sacerdote";
        }
        else if (msj === "Error Existing Relation or Invalid Data")
        {
            return "Error, Relación Existente o Datos Inválidos";
        }
        else if (msj === "Error In Some Data")
        {
            return "Error en Varios Datos";
        }
        else if (msj === "Error Same Data Invalid")
        {
            return "Error Mismos Datos Inválidos";
        }
        else if (msj === "Are You Sure to delete the ")
        {
            return "¿Está seguro de eliminar el registro de ";
        }
        else if (msj === " No.")
        {
            return " No.";
        }
        else if (msj === "communion" || msj == "Communion")
        {
            return "Comunión";
        }
        else if (msj === "baptism" || msj == "Baptism")
        {
            return "Bautismo";
        }
        else if (msj === "church" || msj == "Church")
        {
            return "Iglesia";
        }
        else if (msj === "rector" || msj == "Rector")
        {
            return "Sacerdote";
        }
        else if (msj === "Error Delete The Church, First Delete the Rector from that church")
        {
            return "Error eliminando a la iglesia, primer elimine a los sacerdotes";
        }
        else if (msj === "Sucess Delete")
        {
            return "Eliminación Exitosa";
        }
        else if (msj === "Error Delete The ")
        {
            return "Error, al eliminar el registro de ";
        }
        else if (msj === "marriage" || msj === "Marriage")
        {
            return "Matrimonio";
        }
        else if (msj === "proof" || msj === "Proof")
        {
            return "Comprobante";
        }
        else if (msj === "defuntion" || msj === "Defuntion")
        {
            return "Defunción";
        }
        else if (msj === "communion")
        {
            return "comunión";
        }

    }
    else
    {
        return msj;
    }

    return msj;
}

function parentIdPerson(id, idFather, idMother, type, self)
{
    if (self === undefined)
    {
        parentDocument = window.opener.document;
        parentWindow = window.opener;
    }
    else
    {
        parentDocument = window.document;
        parentWindow = window;
    }  

    if (type === 'boyfriend')
    {
        if (id !== '0')
        {
            parentDocument.getElementById("idBoyfriend").innerHTML = id;

            data = "../JS/Ajax/getPersonData.php?id=" + id;

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    response   = ajax.responseText;
                    dataInside = "";
                    counter    = 0;
                    capture    = false;

                    for (i = 0; i < response.length; i++) 
                    {
                        if (response[i] === '=')
                        {
                            capture = true;
                        }
                        else if (response[i] === '&')
                        {
                            if (counter === 0) //ChildName
                            {
                                parentDocument.getElementById('boyfriendName').value = dataInside;
                            }
                            else if (counter === 1)
                            {
                                parentDocument.getElementById('boyfriendLastname1').value = dataInside;
                            }
                            else if (counter === 2)
                            {
                                parentDocument.getElementById('boyfriendLastname2').value = dataInside;
                            }
                            counter++;
                            dataInside = "";
                            capture = false;
                        }
                        else
                        {
                            if (capture)
                            {
                                dataInside = dataInside + response[i];
                            }
                        }
                    }
                    
                    if (self === undefined)
                    {
                        window.close();
                    }                    
                }
            }

            //Envio de datos al servidor
            ajax.open("GET", data, true);
            ajax.send();
        }

        $(parentDocument.getElementById('btnBoyfriendCheck')).css('display', 'none');
        $(parentDocument.getElementsByClassName('boyfriendData')).attr('colspan', '2');
    }
    else if (type === 'girlfriend')
    {
        if (id !== '0')
        {
            parentDocument.getElementById("idGirlfriend").innerHTML = id;

            data = "../JS/Ajax/getPersonData.php?id=" + id;

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    response   = ajax.responseText;
                    dataInside = "";
                    counter    = 0;
                    capture    = false;

                    for (i = 0; i < response.length; i++) 
                    {
                        if (response[i] === '=')
                        {
                            capture = true;
                        }
                        else if (response[i] === '&')
                        {
                            if (counter === 0) //ChildName
                            {
                                parentDocument.getElementById('girlfriendName').value = dataInside;
                            }
                            else if (counter === 1)
                            {
                                parentDocument.getElementById('girlfriendLastname1').value = dataInside;
                            }
                            else if (counter === 2)
                            {
                                parentDocument.getElementById('girlfriendLastname2').value = dataInside;
                            }
                            counter++;
                            dataInside = "";
                            capture = false;
                        }
                        else
                        {
                            if (capture)
                            {
                                dataInside = dataInside + response[i];
                            }
                        }
                    }
                    
                    if (self === undefined)
                    {
                        window.close();
                    }                    
                }
            }

            //Envio de datos al servidor
            ajax.open("GET", data, true);
            ajax.send();
        }

        $(parentDocument.getElementById('btnGirlfriendCheck')).css('display', 'none');
        $(parentDocument.getElementsByClassName('girlfriendData')).attr('colspan', '2');
    }
    else if (type === 'child')
    {
        if (id !== '0')
        {
            parentDocument.getElementById("idPerson").innerHTML = id;
            parentDocument.getElementById("idFather").innerHTML = idFather;
            parentDocument.getElementById("idMother").innerHTML = idMother;

            data = "../JS/Ajax/getPersonData.php?id=" + id;

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    response   = ajax.responseText;
                    dataInside = "";
                    counter    = 0;
                    capture    = false;

                    for (i = 0; i < response.length; i++) 
                    {
                        if (response[i] === '=')
                        {
                            capture = true;
                        }
                        else if (response[i] === '&')
                        {
                            if (counter === 0) //ChildName
                            {
                                parentDocument.getElementById('childName').value = dataInside;
                            }
                            else if (counter === 1)
                            {
                                parentDocument.getElementById('childLastname1').value = dataInside;
                            }
                            else if (counter === 2)
                            {
                                parentDocument.getElementById('childLastname2').value = dataInside;
                            }
                            else if (counter === 3)
                            {
                                if (parentDocument.getElementById('fatherName') !== null)
                                {
                                    parentDocument.getElementById('fatherName').value = dataInside;

                                    if (dataInside == "")
                                    {
                                        $(parentDocument.getElementById('panel-body-father')).css('display', 'none');
                                        $(parentDocument.getElementById('btnHideFather')).css('display', 'none');
                                        $(parentDocument.getElementById('btnShowFather')).css('display', 'inline');
                                    }
                                    else
                                    {
                                        $(parentDocument.getElementById('panel-body-father')).css('display', 'block');
                                        $(parentDocument.getElementById('btnHideFather')).css('display', 'inline');
                                        $(parentDocument.getElementById('btnShowFather')).css('display', 'none');
                                        $(parentDocument.getElementById('btnFatherCheck')).css('display', 'none');
                                        $(parentDocument.getElementsByClassName('fatherData')).attr('colspan', '1');
                                    }   
                                }
                            }
                            else if (counter === 4)
                            {
                                if (parentDocument.getElementById('fatherLastname1') !== null)
                                {
                                    parentDocument.getElementById('fatherLastname1').value = dataInside;    
                                }
                            }
                            else if (counter === 5)
                            {
                                if (parentDocument.getElementById('fatherLastname2') !== null)
                                {
                                    parentDocument.getElementById('fatherLastname2').value = dataInside;    
                                }
                            }
                            else if (counter === 6)
                            {
                                if (parentDocument.getElementById('motherName') !== null)
                                {
                                    parentDocument.getElementById('motherName').value = dataInside;

                                    if (dataInside == "")
                                    {
                                        $(parentDocument.getElementById('panel-body-mother')).css('display', 'none');
                                        $(parentDocument.getElementById('btnHideMother')).css('display', 'none');
                                        $(parentDocument.getElementById('btnShowMother')).css('display', 'inline');
                                    }
                                    else
                                    {
                                        $(parentDocument.getElementById('panel-body-mother')).css('display', 'block');
                                        $(parentDocument.getElementById('btnHideMother')).css('display', 'inline');
                                        $(parentDocument.getElementById('btnShowMother')).css('display', 'none');
                                        $(parentDocument.getElementById('btnMotherCheck')).css('display', 'none');
                                        $(parentDocument.getElementsByClassName('motherData')).attr('colspan', '1');
                                    }   
                                }
                            }
                            else if (counter === 7)
                            {
                                if (parentDocument.getElementById('motherLastname1') !== null)
                                {
                                    parentDocument.getElementById('motherLastname1').value = dataInside;   
                                }
                            }
                            else if (counter === 8)
                            {
                                if (parentDocument.getElementById('motherLastname2') !== null)
                                {
                                    parentDocument.getElementById('motherLastname2').value = dataInside;    
                                }
                            }
                            else if (counter === 9)
                            {
                                if (parentDocument.getElementById('fatherFNames') !== null)
                                {
                                    parentDocument.getElementById('fatherFNames').value = dataInside;    
                                }                                
                            }
                            else if (counter === 10)
                            {
                                if (parentDocument.getElementById('fatherFLastname1') !== null)
                                {
                                    parentDocument.getElementById('fatherFLastname1').value = dataInside;   
                                }
                            }
                            else if (counter === 11)
                            {
                                if (parentDocument.getElementById('fatherFLastname2') !== null)
                                {
                                    parentDocument.getElementById('fatherFLastname2').value = dataInside;    
                                }
                            }
                            else if (counter === 12)
                            {
                                if (parentDocument.getElementById('fatherMNames') !== null)
                                {
                                    parentDocument.getElementById('fatherMNames').value = dataInside;    
                                }
                            }
                            else if (counter === 13)
                            {
                                if (parentDocument.getElementById('fatherMLastname1') !== null)
                                {
                                    parentDocument.getElementById('fatherMLastname1').value = dataInside;    
                                }
                            }
                            else if (counter === 14)
                            {
                                if (parentDocument.getElementById('fatherMLastname2') !== null)
                                {
                                    parentDocument.getElementById('fatherMLastname2').value = dataInside;    
                                }
                            }
                            else if (counter === 15)
                            {
                                if (parentDocument.getElementById('motherFNames') !== null)
                                {
                                    parentDocument.getElementById('motherFNames').value = dataInside;    
                                }
                            }
                            else if (counter === 16)
                            {
                                if (parentDocument.getElementById('motherFLastname1') !== null)
                                {
                                    parentDocument.getElementById('motherFLastname1').value = dataInside;   
                                }
                            }
                            else if (counter === 17)
                            {
                                if (parentDocument.getElementById('motherFLastname2') !== null)
                                {
                                    parentDocument.getElementById('motherFLastname2').value = dataInside;   
                                }
                            }
                            else if (counter === 18)
                            {
                                if (parentDocument.getElementById('motherMNames') !== null)
                                {
                                    parentDocument.getElementById('motherMNames').value = dataInside;    
                                }
                            }
                            else if (counter === 19)
                            {
                                if (parentDocument.getElementById('motherMLastname1') !== null)
                                {
                                    parentDocument.getElementById('motherMLastname1').value = dataInside;    
                                }
                            }
                            else if (counter === 20)
                            {
                                if (parentDocument.getElementById('motherMLastname2') !== null)
                                {
                                    parentDocument.getElementById('motherMLastname2').value = dataInside;   
                                }
                            }
                            else if (counter === 21)
                            {
                                if (parentDocument.getElementById('idBaptism') !== null)
                                {
                                    parentDocument.getElementById('idBaptism').innerHTML = dataInside;   
                                }
                            }
                            else if (counter === 22)
                            {
                                if (parentDocument.getElementById('baptismDate') !== null)
                                {
                                    parentDocument.getElementById('baptismDate').value = dataInside;   
                                }
                            }
                            else if (counter === 23)
                            {
                                if (parentDocument.getElementById('bookregistryBookBaptism') !== null)
                                {
                                    parentDocument.getElementById('bookregistryBookBaptism').value = dataInside;   
                                }
                            }
                            else if (counter === 24)
                            {
                                if (parentDocument.getElementById('bookregistryPageBaptism') !== null)
                                {
                                    parentDocument.getElementById('bookregistryPageBaptism').value = dataInside;   
                                }
                            }
                            else if (counter === 25)
                            {
                                if (parentDocument.getElementById('bookregistryNumberBaptism') !== null)
                                {
                                    parentDocument.getElementById('bookregistryNumberBaptism').value = dataInside;   
                                }
                            }

                            counter++;
                            dataInside = "";
                            capture = false;
                        }
                        else
                        {
                            if (capture)
                            {
                                dataInside = dataInside + response[i];
                            }
                        }
                    }
                    
                    if (self === undefined)
                    {
                        window.close();
                    }                    
                }
            }

            //Envio de datos al servidor
            ajax.open("GET", data, true);
            ajax.send();
        }
    }
    else if (type === 'father')
    {
        if (id !== '0')
        {
            parentDocument.getElementById("idFather").innerHTML = id;

            data = "../JS/Ajax/getPersonData.php?id=" + id;

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    response   = ajax.responseText;
                    dataInside = "";
                    counter    = 0;
                    capture    = false;

                    for (i = 0; i < response.length; i++) 
                    {
                        if (response[i] === '=')
                        {
                            capture = true;
                        }
                        else if (response[i] === '&')
                        {
                            if (counter === 0) //ChildName
                            {
                                parentDocument.getElementById('fatherName').value = dataInside;
                            }
                            else if (counter === 1)
                            {
                                parentDocument.getElementById('fatherLastname1').value = dataInside;
                            }
                            else if (counter === 2)
                            {
                                parentDocument.getElementById('fatherLastname2').value = dataInside;
                            }
                            else if (counter === 3)
                            {
                                if (parentDocument.getElementById('fatherFNames') !== null)
                                {
                                    parentDocument.getElementById('fatherFNames').value = dataInside;    
                                }
                            }
                            else if (counter === 4)
                            {
                                if (parentDocument.getElementById('fatherFLastname1') !== null)
                                {
                                    parentDocument.getElementById('fatherFLastname1').value = dataInside;   
                                }
                            }
                            else if (counter === 5)
                            {
                                if (parentDocument.getElementById('fatherFLastname2') !== null)
                                {
                                    parentDocument.getElementById('fatherFLastname2').value = dataInside;    
                                }
                            }
                            else if (counter === 6)
                            {
                                if (parentDocument.getElementById('fatherMNames') !== null)
                                {
                                    parentDocument.getElementById('fatherMNames').value = dataInside;    
                                }
                            }
                            else if (counter === 7)
                            {
                                if (parentDocument.getElementById('fatherMLastname1') !== null)
                                {
                                    parentDocument.getElementById('fatherMLastname1').value = dataInside;   
                                }
                            }
                            else if (counter === 8)
                            {
                                if (parentDocument.getElementById('fatherMLastname2') !== null)
                                {
                                    parentDocument.getElementById('fatherMLastname2').value = dataInside;    
                                }
                                
                                break;
                            }

                            counter++;
                            dataInside = "";
                            capture = false;
                        }
                        else
                        {
                            if (capture)
                            {
                                dataInside = dataInside + response[i];
                            }
                        }
                    }
                    
                    if (self === undefined)
                    {
                        window.close();
                    }
                }
            }

            //Envio de datos al servidor
            ajax.open("GET", data, true);
            ajax.send();
        }

        $(parentDocument.getElementById('btnFatherCheck')).css('display', 'none');
        $(parentDocument.getElementsByClassName('fatherData')).attr('colspan', '1');
    }
    else if (type === 'mother')
    {
        if (id !== '0')
        {
            parentDocument.getElementById("idMother").innerHTML = id;

            data = "../JS/Ajax/getPersonData.php?id=" + id;

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    response   = ajax.responseText;
                    dataInside = "";
                    counter    = 0;
                    capture    = false;

                    for (i = 0; i < response.length; i++) 
                    {
                        if (response[i] === '=')
                        {
                            capture = true;
                        }
                        else if (response[i] === '&')
                        {
                            if (counter === 0) //ChildName
                            {
                                parentDocument.getElementById('motherName').value = dataInside;
                            }
                            else if (counter === 1)
                            {
                                parentDocument.getElementById('motherLastname1').value = dataInside;
                            }
                            else if (counter === 2)
                            {
                                parentDocument.getElementById('motherLastname2').value = dataInside;
                            }
                            else if (counter === 3)
                            {
                                if (parentDocument.getElementById('motherFNames') !== null)
                                {
                                    parentDocument.getElementById('motherFNames').value = dataInside;    
                                }
                            }
                            else if (counter === 4)
                            {
                                if (parentDocument.getElementById('motherFLastname1') !== null)
                                {
                                    parentDocument.getElementById('motherFLastname1').value = dataInside;    
                                }
                            }
                            else if (counter === 5)
                            {
                                if (parentDocument.getElementById('motherFLastname2') !== null)
                                {
                                    parentDocument.getElementById('motherFLastname2').value = dataInside;    
                                }
                            }
                            else if (counter === 6)
                            {
                                if (parentDocument.getElementById('motherMNames') !== null)
                                {
                                    parentDocument.getElementById('motherMNames').value = dataInside;    
                                }
                            }
                            else if (counter === 7)
                            {
                                if (parentDocument.getElementById('motherMLastname1') !== null)
                                {
                                    parentDocument.getElementById('motherMLastname1').value = dataInside;    
                                }
                            }
                            else if (counter === 8)
                            {
                                if (parentDocument.getElementById('motherMLastname2') !== null)
                                {
                                    parentDocument.getElementById('motherMLastname2').value = dataInside;    
                                }
                                
                                break;
                            }

                            counter++;
                            dataInside = "";
                            capture = false;
                        }
                        else
                        {
                            if (capture)
                            {
                                dataInside = dataInside + response[i];
                            }
                        }
                    }
                    
                    if (self === undefined)
                    {
                        window.close();
                    }
                }
            }

            //Envio de datos al servidor
            ajax.open("GET", data, true);
            ajax.send();
        }

        $(parentDocument.getElementById('btnMotherCheck')).css('display', 'none');
        $(parentDocument.getElementsByClassName('motherData')).attr('colspan', '1');
    } 

    $(parentDocument.getElementById('btnChildCheck')).css('display', 'none');
    $(parentDocument.getElementsByClassName('childData')).attr('colspan', '2');
    
    if (id === '0')
    {
        window.close();
    }               
}

function getFormerRector(rectorName, idRector)
{
    url = String(window.location);

    if (url.indexOf("onfirmation") === -1)
    {
        nameChurch = $("#church").val();

        if (typeof nameChurch === 'undefined')
        {
            nameChurch = $("#churchMarriage").val();
        }
    }
    else
    {
        nameChurch = "Obispo";
    }

    var ajax = new XMLHttpRequest();
    var data = "../JS/Ajax/gerRectorChurch.php?nameChurch=" + nameChurch;

    //Revision del objeto funcionando
    ajax.onreadystatechange = function() 
    {
        if (ajax.readyState == 4 && ajax.status == 200) 
        {
            if (rectorName === undefined && idRector === undefined)
            {
                $('#insideRector').html('<span class="filter-option pull-left">No</span>');
                $('#insideRector').attr('value', '0');
            }
            else
            {
                $('#insideRector').html('<span class="filter-option pull-left">' + rectorName + '</span>');
                $('#insideRector').attr('value', idRector);
            }

            $("#ulrector").html(ajax.responseText);
        }
    }

    //Envio de datos al servidor
    ajax.open("GET",data,true);
    ajax.send();
}

function closeSession()
{
    var ajax = new XMLHttpRequest();

    //Revision del objeto funcionando
    ajax.onreadystatechange = function() 
    {
        if (ajax.readyState == 4 && ajax.status == 200) 
        {
            //alert(getLangMsj(ajax.responseText));
        }
    }

    //Envio de datos al servidor
    ajax.open("GET","../JS/Ajax/closeConnection.php",true);
    ajax.send();
}

function validateUser()
{
    $('#txtloginu').css('color', 'white');
    $('#txtloginp').css('color', 'white');
    $('#txtUser').css('background-color', 'rgba(255,255,255,0.5)');
    $('#txtPassword').css('background-color', 'rgba(255,255,255,0.5)');
    $('#txtUser').css('color', 'black');
    $('#txtPassword').css('color', 'black');
    $('#txtUser').attr('placeholder', 'Username');
    $('#txtPassword').attr('placeholder', '••••••••');

    username = $('#txtUser').val();
    password = $('#txtPassword').val();
    correct  = true;

    txtUser = document.getElementById('txtUser');
    txtPass = document.getElementById('txtPassword');

    if (username == "")
    {
        $('#txtloginu').css('color', 'red');
        correct = false;
    }

    if (password == "")
    {
        $('#txtloginp').css('color', 'red');
        correct = false;
    }

    if (correct)
    {
        var datosEnv  = '../JS/Ajax/validateUser.php?'+
                        'username='     + username +
                        '&password='    + sha1(password);

        var ajax = new XMLHttpRequest();

        //Revision del objeto funcionando
        ajax.onreadystatechange = function() 
        {
            if (ajax.readyState == 4 && ajax.status == 200) 
            {
                if (ajax.responseText.indexOf("KO") !== -1)
                {
                    txtUser.value             = "";
                    txtUser.placeholder       = "Acceso";
                    txtUser.style.color       = "white";
                    txtUser.style.background  = "rgb(183, 14, 14)"; //Rojo Carmesi

                    txtPass.value            = "";
                    txtPass.placeholder      = "Denegado";
                    txtPass.style.color      = "white";
                    txtPass.style.background = "rgb(183, 14, 14)"; //Rojo Carmesi
                }
                else //OK
                {
                    window.location.href = "main.php#";
                }
            }
        }

        //Envio de datos al servidor
        ajax.open("GET",datosEnv,true);
        ajax.send();
    }
}

function logout()
{
    var ajax = new XMLHttpRequest();

    //Revision del objeto funcionando
    ajax.onreadystatechange = function() 
    {
        if (ajax.readyState == 4 && ajax.status == 200) 
        {
            window.location.href = "index.php";
        }
    }

    //Envio de datos al servidor
    ajax.open("GET","../JS/Ajax/logout.php",true);
    ajax.send();
}

function normalData(page)
{
    if (page === 'churchInsertion.php' || page === 'churchChange.php')
    {
        $("#name").css('color', 'black');
    }
    else if (page === 'vicarInsertion.php')
    {
        $("#name").css('color', 'black');
    }
    else if (page === 'officeInsertion.php')
    {
        $("#number").css('color', 'black');
    }
    else if (page === 'deanInsertion.php')
    {
        $("#name").css('color', 'black');
    }
    else if (page === 'cityInsertion.php')
    {
        $("#name").css('color', 'black');
    }
    else if (page === 'stateInsertion.php')
    {
        $("#name").css('color', 'black');
        $("#shortName").css('color', 'black');
    }
    else if (page === 'stateInsertion.php')
    {
        $("#name").css('color', 'black');
        $("#shortName").css('color', 'black');
    }
    else if (page === 'rectorInsertion.php' || page === 'rectorChange.php')
    {
        $("#name").css('color', 'black');
        $("#lastname1").css('color', 'black');
        $("#lastname2").css('color', 'black');
    }
    else if (page === 'userInsertion.php')
    {
        $("#labelPass1").css('color', 'black');
        $("#labelPass2").css('color', 'black');
        $("#labelUsername").css('color', 'black');
    }
    else if (page === 'baptismInsertion.php'      || page === 'baptismChange.php'      ||
             page === 'communionInsertion.php'    || page === 'communionChange.php'    ||
             page === 'confirmationInsertion.php' || page === 'confirmationChange.php')
    {
        $('#labelName').css('color', 'black');
        $('#labelLastname1').css('color', 'black');
        $('#labelLastname2').css('color', 'black');
        $("#btnInsideChildCheck").css('color', 'white');
        $("#btnInsideFatherCheck").css('color', 'white');
        $("#btnInsideMotherCheck").css('color', 'white');
        $("#labelRector").css('color', 'black');
    }
    else if (page === 'marriageInsertion.php' || page === 'marriageChange.php')
    {
        $('#labelBoyName').css('color', 'black');
        $('#labelBoyLastname1').css('color', 'black');
        $('#labelBoyLastname2').css('color', 'black');
        $('#labelGirlName').css('color', 'black');
        $('#labelGirlLastname1').css('color', 'black');
        $('#labelGirlLastname2').css('color', 'black');
        $("#btnInsideBoyfriendCheck").css('color', 'white');
        $("#btnInsideGirlfriendCheck").css('color', 'white');
        $("#labelRector").css('color', 'black');
    }
    else if (page === 'proofInsertion.php' || page === 'proofChange.php')
    {
        $('#labelName').css('color', 'black');
        $('#labelLastname1').css('color', 'black');
        $('#labelLastname2').css('color', 'black');
        $("#btnInsideChildCheck").css('color', 'white');
        $("#btnInsideFatherCheck").css('color', 'white');
        $("#btnInsideMotherCheck").css('color', 'white');
        $("#labelRector").css('color', 'black');
    }
    else if (page === 'defuntionInsertion.php' || page === 'defuntionChange.php')
    {
        $('#labelName').css('color', 'black');
        $('#labelLastname1').css('color', 'black');
        $('#labelLastname2').css('color', 'black');
        $("#btnInsideChildCheck").css('color', 'white');
    }
    else if (page === 'config.php')
    {
        $('#cbcxt').css('color', 'black');
        $('#cbcyt').css('color', 'black');
        $('#bcxt').css('color', 'black');
        $('#bcyt').css('color', 'black');

        $('#ecxt').css('color', 'black');
        $('#ecyt').css('color', 'black');
        $('#cecxt').css('color', 'black');
        $('#cecyt').css('color', 'black');

        $('#ccxt').css('color', 'black');
        $('#ccyt').css('color', 'black');
        $('#cccxt').css('color', 'black');
        $('#cccyt').css('color', 'black');

        $('#cmxt').css('color', 'black');
        $('#cmyt').css('color', 'black');
        $('#mcxt').css('color', 'black');
        $('#mcyt').css('color', 'black');
        $('#mnxt').css('color', 'black');
        $('#mnyt').css('color', 'black');
        $('#mext').css('color', 'black');
        $('#meyt').css('color', 'black');
        $('#mtxt').css('color', 'black');
        $('#mtyt').css('color', 'black');
    }
}

function validateData(page, status, idUpdate)
{
    if (page === 'churchInsertion.php' || page === 'churchChange.php')
    {
        correct = true;

        if ($("#churchName").val() == '')
        {
            $("#name").css('color', 'red');
            correct = false;
        }

        if (correct)
        {
            if (status === 'insert')
            {
                //Get the data for insert in the database
                var datosEnv  = '../JS/Ajax/insertChurch.php?'+
                                'nameChuch='          + $("#churchName").val()                           +
                                '&typeChurch='        + $("#churchType").val()                           +
                                '&codeChurch='        + $("#churchCode").val()                           +
                                '&addressChurch='     + $("#churchAddress").val()                        +
                                '&colonyChurch='      + $("#churchColony").val()                         +
                                '&postalCodeChurch='  + $("#churchPostalCode").val()                     +
                                '&phoneNumberChurch=' + $("#churchPhoneNumber").val()                    +
                                '&vicar='             + $("#vicar").val()                                +
                                '&dean='              + $("#dean").val()                                 +
                                '&city='              + $("#city").val()                                 +
                                '&niche='             + document.getElementById("inputNiche").checked    +
                                '&maxCol='            + $("#maxCol").val()                               +
                                '&maxRow='            + $("#maxRow").val()                               +
                                '&status='            + 'insert'                                         +
                                '&size='              + $("#size").val();

                var ajax = new XMLHttpRequest();

                //Revision del objeto funcionando
                ajax.onreadystatechange = function() 
                {
                    if (ajax.readyState == 4 && ajax.status == 200) 
                    {
                        if (ajax.responseText.indexOf("KO") !== -1)
                        {
                            alert(getLangMsj("Error Existing Church"));
                        }
                        else //OK
                        {
                            alert(getLangMsj("Sucess Save"));
                            window.location.href = "churchMenu.php";
                        }
                    }
                }

                //Envio de datos al servidor
                ajax.open("GET",datosEnv,true);
                ajax.send();
            }
            else if (status === 'update')
            {
                //Get the data for insert in the database
                var datosEnv  = '../JS/Ajax/insertChurch.php?'+
                                'nameChuch='          + $("#churchName").val()                           +
                                '&typeChurch='        + $("#churchType").val()                           +
                                '&codeChurch='        + $("#churchCode").val()                           +
                                '&addressChurch='     + $("#churchAddress").val()                        +
                                '&colonyChurch='      + $("#churchColony").val()                         +
                                '&postalCodeChurch='  + $("#churchPostalCode").val()                     +
                                '&phoneNumberChurch=' + $("#churchPhoneNumber").val()                    +
                                '&vicar='             + $("#vicar").val()                                +
                                '&dean='              + $("#dean").val()                                 +
                                '&city='              + $("#city").val()                                 +
                                '&niche='             + document.getElementById("inputNiche").checked    +
                                '&maxCol='            + $("#maxCol").val()                               +
                                '&maxRow='            + $("#maxRow").val()                               +
                                '&status='            + 'update'                                         +
                                '&id='                + idUpdate                                         + 
                                '&size='              + $("#size").val();

                var ajax = new XMLHttpRequest();

                //Revision del objeto funcionando
                ajax.onreadystatechange = function() 
                {
                    if (ajax.readyState == 4 && ajax.status == 200) 
                    {
                        if (ajax.responseText.indexOf("KO") !== -1)
                        {
                            alert(getLangMsj("Error Updating Church, Same Data"));
                        }
                        else //OK
                        {
                            alert(getLangMsj("Sucess Save"));
                            window.location.href = "churchMenu.php";
                        }
                    }
                }

                //Envio de datos al servidor
                ajax.open("GET",datosEnv,true);
                ajax.send();
            }
        }
    }
    else if (page === 'officeInsertion.php')
    {
        correct = true;

        if ($("#numberCivil").val() == '')
        {
            $("#number").css('color', 'red');
            correct = false;
        }

        if (correct)
        {
            //Get the data for insert in the database
            var datosEnv  = '../JS/Ajax/insertOffice.php?' + 
                             'numberCivil=' + $("#numberCivil").val() +
                             '&cityName='   + $("#city").val();

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    if (ajax.responseText.indexOf("KO") !== -1)
                    {
                        alert(getLangMsj("Error Existing Office"));
                    }
                    else //OK
                    {
                        alert(getLangMsj("Sucess Save"));
                        window.location.href = status;
                    }
                }
            }

            //Envio de datos al servidor
            ajax.open("GET",datosEnv,true);
            ajax.send();
        }
    }
    else if (page === 'vicarInsertion.php')
    {
        correct = true;

        if ($("#nameVicar").val() == '')
        {
            $("#name").css('color', 'red');
            correct = false;
        }

        if (correct)
        {
            //Get the data for insert in the database
            var datosEnv  = '../JS/Ajax/insertVicar.php?nameVicar=' + $("#nameVicar").val();

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    if (ajax.responseText.indexOf("KO") !== -1)
                    {
                        alert(getLangMsj("Error Existing Vicar"));
                    }
                    else //OK
                    {
                        alert(getLangMsj("Sucess Save"));
                        window.location.href = status;
                    }
                }
            }

            //Envio de datos al servidor
            ajax.open("GET",datosEnv,true);
            ajax.send();
        }
    }
    else if (page === 'deanInsertion.php')
    {
        correct = true;

        if ($("#nameDean").val() == '')
        {
            $("#name").css('color', 'red');
            correct = false;
        }

        if (correct)
        {
            //Get the data for insert in the database
            var datosEnv  = '../JS/Ajax/insertDean.php?nameDean=' + $("#nameDean").val();

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    if (ajax.responseText.indexOf("KO") !== -1)
                    {
                        alert(getLangMsj("Error Existing Dean"));
                    }
                    else //OK
                    {
                        alert(getLangMsj("Sucess Save"));
                        window.location.href = status;
                    }
                }
            }

            //Envio de datos al servidor
            ajax.open("GET",datosEnv,true);
            ajax.send();
        }
    }
    else if (page === 'cityInsertion.php')
    {
        correct = true;

        if ($("#nameCity").val() == '')
        {
            $("#name").css('color', 'red');
            correct = false;
        }

        if (correct)
        {
            //Get the data for insert in the database
            var datosEnv  = '../JS/Ajax/insertCity.php?nameCity=' + $("#nameCity").val() +
                                                      '&state='   + $("#state").val();

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    if (ajax.responseText.indexOf("KO") !== -1)
                    {
                        alert(getLangMsj("Error Existing City"));
                    }
                    else //OK
                    {
                        alert(getLangMsj("Sucess Save"));
                        window.location.href = status;
                    }
                }
            }

            //Envio de datos al servidor
            ajax.open("GET",datosEnv,true);
            ajax.send();
        }
    }
    else if (page === 'stateInsertion.php')
    {
        correct = true;

        if ($("#nameState").val() == '')
        {
            $("#name").css('color', 'red');
            correct = false;
        }

        if ($("#shortnameState").val() == '')
        {
            $("#shortName").css('color', 'red');
            correct = false;
        }

        if (correct)
        {
            //Get the data for insert in the database
            var datosEnv  = '../JS/Ajax/insertState.php?nameState='    + $("#nameState").val()      +
                                                      '&shortState='   + $("#shortnameState").val() +
                                                      '&country='      + $("#contryState").val();

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    if (ajax.responseText.indexOf("KO") !== -1)
                    {
                        alert(getLangMsj("Error Existing City"));
                    }
                    else //OK
                    {
                        alert(getLangMsj("Sucess Save"));
                        window.location.href = 'cityInsertion.php';
                    }
                }
            }

            //Envio de datos al servidor
            ajax.open("GET",datosEnv,true);
            ajax.send();
        }
    }
    else if (page === 'rectorInsertion.php' || page === 'rectorChange.php')
    {
        correct = true;

        if ($("#rectorName").val() == '')
        {
            $("#name").css('color', 'red');
            correct = false;
        }

        if ($("#rectorLastname1").val() == '')
        {
            $("#lastname1").css('color', 'red');
            correct = false;
        }

        if ($("#rectorLastname2").val() == '')
        {
            $("#lastname2").css('color', 'red');
            correct = false;
        }

        if (correct)
        {
            if (status === 'insert')
            {
                //Get the data for insert in the database
                var datosEnv  = '../JS/Ajax/insertRector.php?'                    +
                                'name='          + $("#rectorName").val()         +
                                '&lastname1='    + $("#rectorLastname1").val()    +
                                '&lastname2='    + $("#rectorLastname2").val()    +
                                '&type='         + $("#type").val()               +
                                '&statusR='      + $("#status").val()             +
                                '&position='     + $("#position").val()           +
                                '&status='       + 'insert'                       +
                                '&actualChurch=' + $("#church").val();

                var ajax = new XMLHttpRequest();

                //Revision del objeto funcionando
                ajax.onreadystatechange = function() 
                {
                    if (ajax.readyState == 4 && ajax.status == 200) 
                    {                        
                        if (ajax.responseText.indexOf("KO") !== -1)
                        {
                            alert(getLangMsj("Error Existing Rector"));
                        }
                        else //OK
                        {
                            alert(getLangMsj("Sucess Save"));
                            window.location.href = "rectorMenu.php";
                        }
                    }
                }

                //Envio de datos al servidor
                ajax.open("GET",datosEnv,true);
                ajax.send();
            }
            else if (status === 'update')
            {
                //Get the data for insert in the database
                var datosEnv  = '../JS/Ajax/insertRector.php?'                    +
                                'id='            + idUpdate                       + 
                                '&name='         + $("#rectorName").val()         +
                                '&lastname1='    + $("#rectorLastname1").val()    +
                                '&lastname2='    + $("#rectorLastname2").val()    +
                                '&type='         + $("#type").val()               +
                                '&statusR='      + $("#status").val()             +
                                '&position='     + $("#position").val()           +
                                '&status='       + 'update'                       +
                                '&actualChurch=' + $("#church").val();

                var ajax = new XMLHttpRequest();

                //Revision del objeto funcionando
                ajax.onreadystatechange = function() 
                {
                    if (ajax.readyState == 4 && ajax.status == 200) 
                    {
                        if (ajax.responseText.indexOf("KO") !== -1)
                        {
                            alert(getLangMsj("Error Same Rector Data"));
                        }
                        else //OK
                        {
                            alert(getLangMsj("Sucess Save"));
                            window.location.href = "rectorMenu.php";
                        }
                    }
                }

                //Envio de datos al servidor
                ajax.open("GET",datosEnv,true);
                ajax.send();
            }
        }
    }
    else if (page === 'addRelationChurchRector.php')
    {
        //Get the data for insert in the database
        var datosEnv  = '../JS/Ajax/insertRelationCR.php?'             +
                                    'church='  + $("#church").val()    +
                                    '&rector=' + String( $(document.getElementById($("#rector").val())).attr('lang') );

        var ajax = new XMLHttpRequest();

        //Revision del objeto funcionando
        ajax.onreadystatechange = function() 
        {
            if (ajax.readyState == 4 && ajax.status == 200) 
            {
                if (ajax.responseText.indexOf("KO") !== -1)
                {
                    alert(getLangMsj("Error Existing Relation or Invalid Data"));
                }
                else //OK
                {
                    alert(getLangMsj("Sucess Save"));
                    window.location.href = status;
                }
            }
        }

        //Envio de datos al servidor
        ajax.open("GET",datosEnv,true);
        ajax.send();
    }
    else if (page === 'baptismInsertion.php')
    {
        correct = true;

        childname       = $("#childName").val();
        childlastname1  = $("#childLastname1").val();
        childlastname2  = $("#childLastname2").val();

        church          = $("#church").val();
        rector          = $("#insideRector").attr('value');

        statusBtnChild  = $("#btnChildCheck").css('display');
        statusBtnFather = $("#btnFatherCheck").css('display');
        statusBtnMother = $("#btnMotherCheck").css('display');

        if (childname === '' || childname === undefined)
        {
            $('#labelName').css('color', 'red');
            correct = false;
        }

        if (childlastname1 === '' || childlastname1 === undefined)
        {
            $('#labelLastname1').css('color', 'red');
            correct = false;
        }

        if (childlastname2 === '' || childlastname2 === undefined)
        {
            $('#labelLastname2').css('color', 'red');
            correct = false;
        }

        if (statusBtnChild !== 'none')
        {
            $("#btnInsideChildCheck").css('color', 'red');
            correct = false;
        }

        if (statusBtnFather !== 'none')
        {
            if ($('#panel-body-father').css('display') != 'none')
            {
                $("#btnInsideFatherCheck").css('color', 'red');
                correct = false;
            }
        }

        if (statusBtnMother !== 'none')
        {
            if ($('#panel-body-mother').css('display') != 'none')
            {
                $("#btnInsideMotherCheck").css('color', 'red');
                correct = false;
            }
        }

        if (rector == 0)
        {
            $("#labelRector").css('color', 'red');
            correct = false;
        }

        if (correct)
        {
            $.ajax
            ({
                data: {
                        'idBaptism'           : $('#idBaptism').html()          ,
                        'idChild'             : $('#idPerson').html()           , 
                        'nameChild'           : childname                       ,
                        'lastname1Child'      : childlastname1                  ,
                        'lastname2Child'      : childlastname2                  ,

                        'bornDateChild'       : $('#childBornDate').val()       ,
                        'bornPlaceChild'      : $('#childBornPlace').val()      ,
                        'genderChild'         : $('#childGender').val()         ,
                        'legitimateChild'     : $('#childLegitimate').val()     ,

                        'celebrationChurch'   : church                          ,
                        'rectorId'            : rector                          ,
                        'status'              : status                          ,
                        'celebrationDate'     : $('#childBaptismDate').val()    ,

                        'idFather'            : $('#idFather').html()           , 
                        'nameFather'          : $('#fatherName').val()          ,
                        'lastname1Father'     : $('#fatherLastname1').val()     ,
                        'lastname2Father'     : $('#fatherLastname2').val()     ,
                        'nameFatherM'         : $('#fatherMNames').val()        ,
                        'lastname1FatherM'    : $('#fatherMLastname1').val()    ,
                        'lastname2FatherM'    : $('#fatherMLastname2').val()    ,
                        'nameFatherF'         : $('#fatherFNames').val()        ,
                        'lastname1FatherF'    : $('#fatherFLastname1').val()    ,
                        'lastname2FatherF'    : $('#fatherFLastname2').val()    ,

                        'idMother'            : $('#idMother').html()           , 
                        'nameMother'          : $('#motherName').val()          ,
                        'lastname1Mother'     : $('#motherLastname1').val()     ,
                        'lastname2Mother'     : $('#motherLastname2').val()     ,
                        'nameMotherM'         : $('#motherMNames').val()        ,
                        'lastname1MotherM'    : $('#motherMLastname1').val()    ,
                        'lastname2MotherM'    : $('#motherMLastname2').val()    ,
                        'nameMotherF'         : $('#motherFNames').val()        ,
                        'lastname1MotherF'    : $('#motherFLastname1').val()    ,
                        'lastname2MotherF'    : $('#motherFLastname2').val()    ,

                        'nameGodFather'       : $('#godfatherName').val()       ,
                        'lastname1GodFather'  : $('#godfatherLastname1').val()  ,
                        'lastname2GodFather'  : $('#godfatherLastname2').val()  ,

                        'nameGodMother'       : $('#godmotherName').val()       ,
                        'lastname1GodMother'  : $('#godmotherLastname1').val()  ,
                        'lastname2GodMother'  : $('#godmotherLastname2').val()  ,

                        'bookBookRegistry'    : $('#bookregistryBook').val()    ,
                        'pageBookRegistry'    : $('#bookregistryPage').val()    ,
                        'numBookRegistry'     : $('#bookregistryNumber').val()  ,
                        'reverseBookRegistry' : $('#reverse').val()             ,

                        'bookCivilRegistry'   : $('#civilregistryBook').val()   ,
                        'pageCivilRegistry'   : $('#civilregistryPage').val()   ,
                        'numCivilRegistry'    : $('#civilregistryNumber').val() ,
                        'officeCivilRegistry' : $('#civilregistryOffice').val()
                      },

                type: "POST",
                url: '../JS/Ajax/insertBaptism.php',
            })
            .done(function( data, textStatus, jqXHR ) 
            {
                if (data.indexOf("KO") !== -1)
                {
                    alert(getLangMsj("Error In Some Data"));
                }
                else //OK
                {
                    alert(getLangMsj("Sucess Save"));
                    window.location.href = "baptismMenu.php";
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) 
            {
                alert(getLangMsj("Error Same Data Invalid"));
            });
        }
    }
    else if (page === 'communionInsertion.php')
    {
        correct = true;

        childname       = $("#childName").val();
        childlastname1  = $("#childLastname1").val();
        childlastname2  = $("#childLastname2").val();

        church          = $("#church").val();
        rector          = $("#insideRector").attr('value');

        statusBtnChild  = $("#btnChildCheck").css('display');
        statusBtnFather = $("#btnFatherCheck").css('display');
        statusBtnMother = $("#btnMotherCheck").css('display');

        if (childname === '' || childname === undefined)
        {
            $('#labelName').css('color', 'red');
            correct = false;
        }

        if (childlastname1 === '' || childlastname1 === undefined)
        {
            $('#labelLastname1').css('color', 'red');
            correct = false;
        }

        if (childlastname2 === '' || childlastname2 === undefined)
        {
            $('#labelLastname2').css('color', 'red');
            correct = false;
        }

        if (statusBtnChild !== 'none')
        {
            $("#btnInsideChildCheck").css('color', 'red');
            correct = false;
        }

        if (statusBtnFather !== 'none')
        {
            if ($('#panel-body-father').css('display') != 'none')
            {
                $("#btnInsideFatherCheck").css('color', 'red');
                correct = false;
            }
        }

        if (statusBtnMother !== 'none')
        {
            if ($('#panel-body-mother').css('display') != 'none')
            {
                $("#btnInsideMotherCheck").css('color', 'red');
                correct = false;
            }
        }

        if (rector == 0)
        {
            $("#labelRector").css('color', 'red');
            correct = false;
        }

        if (correct)
        {
            $.ajax
            ({
                data: {
                        'idCommunion'         : $('#idCommunion').html()        ,
                        'idChild'             : $('#idPerson').html()           , 
                        'nameChild'           : childname                       ,
                        'lastname1Child'      : childlastname1                  ,
                        'lastname2Child'      : childlastname2                  ,

                        'celebrationChurch'   : church                          ,
                        'rectorId'            : rector                          ,
                        'status'              : status                          ,
                        'celebrationDate'     : $('#childCommunionDate').val()  ,

                        'idFather'            : $('#idFather').html()           , 
                        'nameFather'          : $('#fatherName').val()          ,
                        'lastname1Father'     : $('#fatherLastname1').val()     ,
                        'lastname2Father'     : $('#fatherLastname2').val()     ,

                        'idMother'            : $('#idMother').html()           , 
                        'nameMother'          : $('#motherName').val()          ,
                        'lastname1Mother'     : $('#motherLastname1').val()     ,
                        'lastname2Mother'     : $('#motherLastname2').val()     ,

                        'nameGodFather'       : $('#godfatherName').val()       ,
                        'lastname1GodFather'  : $('#godfatherLastname1').val()  ,
                        'lastname2GodFather'  : $('#godfatherLastname2').val()  ,

                        'bookBookRegistry'    : $('#bookregistryBook').val()    ,
                        'pageBookRegistry'    : $('#bookregistryPage').val()    ,
                        'numBookRegistry'     : $('#bookregistryNumber').val()  ,
                        'reverseBookRegistry' : $('#reverse').val()             ,
                      },

                type: "POST",
                url: '../JS/Ajax/insertCommunion.php',
            })
            .done(function( data, textStatus, jqXHR ) 
            {
                if (data.indexOf("KO") !== -1)
                {
                    alert(getLangMsj("Error In Some Data"));
                }
                else //OK
                {
                    alert(getLangMsj("Sucess Save"));
                    window.location.href = "communionMenu.php";
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) 
            {
                alert(getLangMsj("Error Same Data Invalid"));
            });
        }
    }
    else if (page === 'confirmationInsertion.php')
    {
        correct = true;

        childname       = $("#childName").val();
        childlastname1  = $("#childLastname1").val();
        childlastname2  = $("#childLastname2").val();

        church          = $("#church").val();
        rector          = $("#insideRector").attr('value');

        statusBtnChild  = $("#btnChildCheck").css('display');
        statusBtnFather = $("#btnFatherCheck").css('display');
        statusBtnMother = $("#btnMotherCheck").css('display');

        if (childname === '' || childname === undefined)
        {
            $('#labelName').css('color', 'red');
            correct = false;
        }

        if (childlastname1 === '' || childlastname1 === undefined)
        {
            $('#labelLastname1').css('color', 'red');
            correct = false;
        }

        if (childlastname2 === '' || childlastname2 === undefined)
        {
            $('#labelLastname2').css('color', 'red');
            correct = false;
        }

        if (statusBtnChild !== 'none')
        {
            $("#btnInsideChildCheck").css('color', 'red');
            correct = false;
        }

        if (statusBtnFather !== 'none')
        {
            if ($('#panel-body-father').css('display') != 'none')
            {
                $("#btnInsideFatherCheck").css('color', 'red');
                correct = false;
            }
        }

        if (statusBtnMother !== 'none')
        {
            if ($('#panel-body-mother').css('display') != 'none')
            {
                $("#btnInsideMotherCheck").css('color', 'red');
                correct = false;
            }
        }

        if (rector == 0)
        {
            $("#labelRector").css('color', 'red');
            correct = false;
        }

        if (correct)
        {
            $.ajax
            ({
                data: {
                        'idConfirmation'      : $('#idConfirmation').html()       ,
                        'idChild'             : $('#idPerson').html()             , 
                        'nameChild'           : childname                         ,
                        'lastname1Child'      : childlastname1                    ,
                        'lastname2Child'      : childlastname2                    ,

                        'celebrationChurch'   : church                            ,
                        'rectorId'            : rector                            ,
                        'status'              : status                            ,
                        'celebrationDate'     : $('#childConfirmationDate').val() ,

                        'idFather'            : $('#idFather').html()             , 
                        'nameFather'          : $('#fatherName').val()            ,
                        'lastname1Father'     : $('#fatherLastname1').val()       ,
                        'lastname2Father'     : $('#fatherLastname2').val()       ,

                        'idMother'            : $('#idMother').html()             , 
                        'nameMother'          : $('#motherName').val()            ,
                        'lastname1Mother'     : $('#motherLastname1').val()       ,
                        'lastname2Mother'     : $('#motherLastname2').val()       ,

                        'nameGodFather'       : $('#godfatherName').val()         ,
                        'lastname1GodFather'  : $('#godfatherLastname1').val()    ,
                        'lastname2GodFather'  : $('#godfatherLastname2').val()    ,

                        'bookBookRegistry'    : $('#bookregistryBook').val()      ,
                        'pageBookRegistry'    : $('#bookregistryPage').val()      ,
                        'numBookRegistry'     : $('#bookregistryNumber').val()    ,
                        'reverseBookRegistry' : $('#reverse').val()               ,
                        
                        'bookBookRegistryB'    : $('#bookregistryBookBaptism').val()   ,
                        'pageBookRegistryB'    : $('#bookregistryPageBaptism').val()   ,
                        'numBookRegistryB'     : $('#bookregistryNumberBaptism').val() ,
                        'baptismChurch'        : $("#churchBaptism").val()             ,
                        'baptismId'            : $('#idBaptism').html()                ,
                        'baptismDate'          : $('#baptismDate').val()               ,
                      },

                type: "POST",
                url: '../JS/Ajax/insertConfirmation.php',
            })
            .done(function( data, textStatus, jqXHR ) 
            {               
                if (data.indexOf("KO") !== -1)
                {
                    alert(getLangMsj("Error In Some Data"));
                }
                else //OK
                {
                    alert(getLangMsj("Sucess Save"));
                    window.location.href = "confirmationMenu.php";
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) 
            {
                alert(getLangMsj("Error Same Data Invalid"));
            });
        }
    }
    else if (page === 'marriageInsertion.php')
    {
        correct = true;

        boyfriendname       = $("#boyfriendName").val();
        boyfriendlastname1  = $("#boyfriendLastname1").val();
        boyfriendlastname2  = $("#boyfriendLastname2").val();

        girlfriendname       = $("#girlfriendName").val();
        girlfriendlastname1  = $("#girlfriendLastname1").val();
        girlfriendlastname2  = $("#girlfriendLastname2").val();

        churchMarriage  = $("#churchMarriage").val();
        churchProcess   = $("#churchProcess").val();
        rector          = $("#insideRector").attr('value');

        statusBtnBoyfriend  = $("#btnBoyfriendCheck").css('display');
        statusBtnGirlfriend = $("#btnGirlfriendCheck").css('display');

        if (boyfriendname === '' || boyfriendname === undefined)
        {
            $('#labelBoyName').css('color', 'red');
            correct = false;
        }

        if (boyfriendlastname1 === '' || boyfriendlastname1 === undefined)
        {
            $('#labelBoyLastname1').css('color', 'red');
            correct = false;
        }

        if (boyfriendlastname2 === '' || boyfriendlastname2 === undefined)
        {
            $('#labelBoyLastname2').css('color', 'red');
            correct = false;
        }

        if (girlfriendname === '' || girlfriendname === undefined)
        {
            $('#labelGirlName').css('color', 'red');
            correct = false;
        }

        if (girlfriendlastname1 === '' || girlfriendlastname1 === undefined)
        {
            $('#labelGirlLastname1').css('color', 'red');
            correct = false;
        }

        if (girlfriendlastname2 === '' || girlfriendlastname2 === undefined)
        {
            $('#labelGirlLastname2').css('color', 'red');
            correct = false;
        }

        if (statusBtnBoyfriend !== 'none')
        {
            $("#btnInsideBoyfriendCheck").css('color', 'red');
            correct = false;
        }

        if (statusBtnGirlfriend !== 'none')
        {
            $("#btnInsideGirlfriendCheck").css('color', 'red');
            correct = false;
        }

        if (rector == 0)
        {
            $("#labelRector").css('color', 'red');
            correct = false;
        }

        if (correct)
        {
            $.ajax
            ({
                data: {
                        'idMarriage'          : $('#idMarriage').html()         ,

                        'idBoyfriend'         : $('#idBoyfriend').html()        , 
                        'boyfriendName'       : boyfriendname                   ,
                        'lastname1Boyfriend'  : boyfriendlastname1              ,
                        'lastname2Boyfriend'  : boyfriendlastname2              ,

                        'idGirlfriend'        : $('#idGirlfriend').html()       , 
                        'girlfriendName'      : girlfriendname                  ,
                        'lastname1Girlfriend' : girlfriendlastname1             ,
                        'lastname2Girlfriend' : girlfriendlastname2             ,

                        'celebrationChurch'   : churchMarriage                  ,
                        'processChurch'       : churchProcess                   ,
                        'rectorId'            : rector                          ,
                        'status'              : status                          ,
                        'celebrationDate'     : $('#marriageDate').val()        ,

                        'nameGodFather'       : $('#godfatherName').val()       ,
                        'lastname1GodFather'  : $('#godfatherLastname1').val()  ,
                        'lastname2GodFather'  : $('#godfatherLastname2').val()  ,

                        'nameGodMother'       : $('#godmotherName').val()       ,
                        'lastname1GodMother'  : $('#godmotherLastname1').val()  ,
                        'lastname2GodMother'  : $('#godmotherLastname2').val()  ,

                        'nameWitness1'        : $('#witness1Name').val()        ,
                        'lastname1Witness1'   : $('#witness1Lastname1').val()   ,
                        'lastname2Witness1'   : $('#witness1Lastname2').val()   ,

                        'nameWitness2'        : $('#witness2Name').val()        ,
                        'lastname1Witness2'   : $('#witness2Lastname1').val()   ,
                        'lastname2Witness2'   : $('#witness2Lastname2').val()   ,

                        'bookBookRegistry'    : $('#bookregistryBook').val()    ,
                        'pageBookRegistry'    : $('#bookregistryPage').val()    ,
                        'numBookRegistry'     : $('#bookregistryNumber').val()  ,
                        'reverseBookRegistry' : $('#reverse').val()             
                      },

                type: "POST",
                url: '../JS/Ajax/insertMarriage.php',
            })
            .done(function( data, textStatus, jqXHR ) 
            {
                if (data.indexOf("KO") !== -1)
                {
                    alert(getLangMsj("Error In Some Data"));
                }
                else //OK
                {
                    alert(getLangMsj("Sucess Save"));
                    window.location.href = "marriageMenu.php";
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) 
            {
                alert(getLangMsj("Error Same Data Invalid"));
            });
        }
    }
    else if (page === 'proofInsertion.php')
    {
        correct = true;

        childname       = $("#childName").val();
        childlastname1  = $("#childLastname1").val();
        childlastname2  = $("#childLastname2").val();

        church          = $("#church").val();

        statusBtnChild  = $("#btnChildCheck").css('display');
        statusBtnFather = $("#btnFatherCheck").css('display');
        statusBtnMother = $("#btnMotherCheck").css('display');

        if (childname === '' || childname === undefined)
        {
            $('#labelName').css('color', 'red');
            correct = false;
        }

        if (childlastname1 === '' || childlastname1 === undefined)
        {
            $('#labelLastname1').css('color', 'red');
            correct = false;
        }

        if (childlastname2 === '' || childlastname2 === undefined)
        {
            $('#labelLastname2').css('color', 'red');
            correct = false;
        }

        if (statusBtnChild !== 'none')
        {
            $("#btnInsideChildCheck").css('color', 'red');
            correct = false;
        }

        if (statusBtnFather !== 'none')
        {
            if ($('#panel-body-father').css('display') != 'none')
            {
                $("#btnInsideFatherCheck").css('color', 'red');
                correct = false;
            }
        }

        if (statusBtnMother !== 'none')
        {
            if ($('#panel-body-mother').css('display') != 'none')
            {
                $("#btnInsideMotherCheck").css('color', 'red');
                correct = false;
            }
        }

        if ($('#panel-body-godmother').css('display') == 'none')
        {
            $('#godmotherName').val('');
            $('#godmotherLastname1').val('');
            $('#godmotherLastname2').val('');
        }

        if ($('#panel-body-godfather').css('display') == 'none')
        {
            $('#godfatherName').val('');
            $('#godfatherLastname1').val('');
            $('#godfatherLastname2').val('');
        }

        if (correct)
        {
            $.ajax
            ({
                data: {
                        'idProof'             : $('#idProof').html()                      ,
                        'idChild'             : $('#idPerson').html()                     , 
                        'nameChild'           : childname                                 ,
                        'lastname1Child'      : childlastname1                            ,
                        'lastname2Child'      : childlastname2                            ,

                        'addressChild'        : $('#childAddress').val()                  ,
                        'phoneChild'          : $('#childPhone').val()                    ,
                        'cityChild'           : $("#city").val()                          ,

                        'celebrationChurch'   : church                                    ,
                        'status'              : status                                    ,
                        'type' : document.getElementById("type").selectedIndex.toString() ,

                        'idFather'            : $('#idFather').html()                     , 
                        'nameFather'          : $('#fatherName').val()                    ,
                        'lastname1Father'     : $('#fatherLastname1').val()               ,
                        'lastname2Father'     : $('#fatherLastname2').val()               ,

                        'idMother'            : $('#idMother').html()                     , 
                        'nameMother'          : $('#motherName').val()                    ,
                        'lastname1Mother'     : $('#motherLastname1').val()               ,
                        'lastname2Mother'     : $('#motherLastname2').val()               ,

                        'nameGodFather'       : $('#godfatherName').val()                 ,
                        'lastname1GodFather'  : $('#godfatherLastname1').val()            ,
                        'lastname2GodFather'  : $('#godfatherLastname2').val()            ,

                        'nameGodMother'       : $('#godmotherName').val()                 ,
                        'lastname1GodMother'  : $('#godmotherLastname1').val()            ,
                        'lastname2GodMother'  : $('#godmotherLastname2').val()            
                      },

                type: "POST",
                url: '../JS/Ajax/insertProof.php',
            })
            .done(function( data, textStatus, jqXHR ) 
            {
                if (data.indexOf("KO") !== -1)
                {
                    alert(getLangMsj("Error In Some Data"));
                }
                else //OK
                {
                    alert(getLangMsj("Sucess Save"));
                    window.location.href = "proofMenu.php";
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) 
            {
                alert(getLangMsj("Error Same Data Invalid"));
            });
        }
    }
    else if (page === 'userInsertion.php')
    {
        correct = true;

        username        = $("#userName").val();
        userPass1       = $("#userPass1").val();
        userPass2       = $("#userPass2").val();
        church          = $("#church").val();

        if (username === '' || username === undefined)
        {
            $('#labelUsername').css('color', 'red');
            correct = false;
        }
        else
        {
            indexSpace = username.indexOf(" ");

            if (indexSpace !== -1)
            {
                username = username.substring(0, indexSpace);
                $("#userName").val(username);
            }
        }

        if (userPass1 === '' || userPass1 === undefined)
        {
            $('#labelPass1').css('color', 'red');
            correct = false;
        }

        if (userPass2 === '' || userPass2 === undefined)
        {
            $('#labelPass2').css('color', 'red');
            correct = false;
        }

        if (userPass1 !== userPass2)
        {
            $('#labelPass1').css('color', 'red');
            $('#labelPass2').css('color', 'red');
            correct = false;
        }

        if (correct)
        {
            $.ajax
            ({
                data: {
                        'username'            : username                                  ,
                        'password'            : userPass1                                 , 
                        'church'              : church                                    ,
                        'status'              : status                                    ,
                        'type' : document.getElementById("type").selectedIndex.toString() ,
                      },

                type: "POST",
                url: '../JS/Ajax/insertUser.php',
            })
            .done(function( data, textStatus, jqXHR ) 
            {
                if (data.indexOf("KO") !== -1)
                {
                    alert(getLangMsj("Error In Some Data"));
                }
                else //OK
                {
                    alert(getLangMsj("Sucess Save"));
                    window.location.href = "userMenu.php";
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) 
            {
                alert(getLangMsj("Error Same Data Invalid"));
            });
        }
    }
    else if (page === 'defuntionInsertion.php')
    {
        correct = true;

        childname       = $("#childName").val();
        childlastname1  = $("#childLastname1").val();
        childlastname2  = $("#childLastname2").val();

        church          = $("#church").val();

        statusBtnChild  = $("#btnChildCheck").css('display');

        if (childname === '' || childname === undefined)
        {
            $('#labelName').css('color', 'red');
            correct = false;
        }

        if (childlastname1 === '' || childlastname1 === undefined)
        {
            $('#labelLastname1').css('color', 'red');
            correct = false;
        }

        if (childlastname2 === '' || childlastname2 === undefined)
        {
            $('#labelLastname2').css('color', 'red');
            correct = false;
        }

        if (statusBtnChild !== 'none')
        {
            $("#btnInsideChildCheck").css('color', 'red');
            correct = false;
        }

        if (correct)
        {
            $.ajax
            ({
                data: {
                        'idDefuntion'         : $('#idDefuntion').html()                      ,
                        'idChild'             : $('#idPerson').html()                         , 
                        'nameChild'           : childname                                     ,
                        'lastname1Child'      : childlastname1                                ,
                        'lastname2Child'      : childlastname2                                ,

                        'status'              : status                                        ,
                        'idCrypt'             : $('#idCrypt').html()                          ,

                        'celebrationChurch'   : church                                        ,
                        'celebrationDate'     : $('#childDefuntionDate').val()                ,
                        'inCrypt'             : document.getElementById('inputCrypt').checked ,
                        'cryptColumn'         : $('#col').val()                               ,
                        'cryptRow'            : $('#row').val()                               ,
                        'cryptNumber'         : $('#size').val()                 
                      },

                type: "POST",
                url: '../JS/Ajax/insertDefuntion.php',
            })
            .done(function( data, textStatus, jqXHR ) 
            {
                if (data.indexOf("KO") !== -1)
                {
                    alert(getLangMsj("Error In Some Data"));
                }
                else //OK
                {
                    alert(getLangMsj("Sucess Save"));
                    window.location.href = "defuntionMenu.php";
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) 
            {
                alert(getLangMsj("Error Same Data Invalid"));
            });
        }
    }
    else if (page === 'config.php')
    {
        correct = true;

        cbcx = $('#cbcx').val();
        cbcy = $('#cbcy').val();
        bcx  = $('#bcx').val();
        bcy  = $('#bcy').val();

        ecx  = $('#ecx').val();
        ecy  = $('#ecy').val();
        cecx = $('#cecx').val();
        cecy = $('#cecy').val();

        ccx  = $('#ccx').val();
        ccy  = $('#ccy').val();
        cccx = $('#cccx').val();
        cccy = $('#cccy').val();

        mcx  = $('#mcx').val();
        mcy  = $('#mcy').val();
        mbx  = $('#mbx').val();
        mby  = $('#mby').val();
        mnx  = $('#mnx').val();
        mny  = $('#mny').val();
        mex  = $('#mex').val();
        mey  = $('#mey').val();
        mtx  = $('#mtx').val();
        mty  = $('#mty').val();

        if (cbcx === '')
        {
            $('#cbcxt').css('color', 'red');
            correct = false;
        }

        if (cbcy === '')
        {
            $('#cbcyt').css('color', 'red');
            correct = false;
        }

        if (bcx === '')
        {
            $('#bcxt').css('color', 'red');
            correct = false;
        }

        if (bcy === '')
        {
            $('#bcyt').css('color', 'red');
            correct = false;
        }

        if (ecx === '')
        {
            $('#ecxt').css('color', 'red');    
            correct = false;
        }        

        if (ecy === '')
        {
            $('#ecyt').css('color', 'red');
            correct = false;    
        }
        
        if (cecx === '')
        {
            $('#cecxt').css('color', 'red');    
            correct = false;
        }

        if (cecy === '')
        {
            $('#cecyt').css('color', 'red');    
            correct = false;
        }
        
        if (ccx === '')
        {
            $('#ccxt').css('color', 'red');    
            correct = false;
        }
        
        if (ccy === '')
        {
            $('#ccyt').css('color', 'red');    
            correct = false;
        }
        
        if (cccx === '')
        {
            $('#cccxt').css('color', 'red');    
            correct = false;
        }
        
        if (cccy === '')
        {
            $('#cccyt').css('color', 'red');
            correct = false;    
        }

        if (mcx === '')
        {
            $('#cmxt').css('color', 'red');    
            correct = false;
        }

        if (mcy === '')
        {
            $('#cmyt').css('color', 'red');    
            correct = false;
        }
        
        if (mbx === '')
        {
            $('#mcxt').css('color', 'red');    
            correct = false;
        }
        
        if (mby === '')
        {
            $('#mcyt').css('color', 'red');    
            correct = false;
        }
        
        if (mnx === '')
        {
            $('#mnxt').css('color', 'red');    
            correct = false;
        }
        
        if (mny === '')
        {
            $('#mnyt').css('color', 'red');    
            correct = false;
        }

        if (mex === '')
        {
            $('#mext').css('color', 'red');    
            correct = false;
        }

        if (mey === '')
        {
            $('#meyt').css('color', 'red');    
            correct = false;
        }
        
        if (mtx === '')
        {
            $('#mtxt').css('color', 'red');    
            correct = false;
        }
        
        if (mty === '')
        {
            $('#mtyt').css('color', 'red');    
            correct = false;
        }
        
        if (correct)
        {
            $.ajax
            ({
                data: {
                        'language' : $('#language').val(),
                        'cbcx'     : cbcx                , 
                        'cbcy'     : cbcy                ,
                        'bcx'      : bcx                 ,
                        'bcy'      : bcy                 ,
                        
                        'ecx'      : ecx                 ,
                        'ecy'      : ecy                 ,
                        'cecx'     : cecx                ,
                        'cecy'     : cecy                ,

                        'ccx'      : ccx                 ,
                        'ccy'      : ccy                 ,
                        'cccx'     : cccx                ,
                        'cccy'     : cccy                ,
                        
                        'mcx'      : mcx                 ,
                        'mcy'      : mcy                 ,
                        'mbx'      : mbx                 ,
                        'mby'      : mby                 ,
                        'mnx'      : mnx                 ,
                        'mny'      : mny                 ,
                        'mex'      : mex                 ,
                        'mey'      : mey                 ,
                        'mtx'      : mtx                 ,
                        'mty'      : mty                 
                      },

                type: "POST",
                url: '../JS/Ajax/config.php',
            })
            .done(function( data, textStatus, jqXHR ) 
            {
                if (data.indexOf("KO") !== -1)
                {
                    alert(getLangMsj("Error In Some Data"));
                }
                else //OK
                {
                    window.location.href = "config.php?success=true";
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) 
            {
                alert(getLangMsj("Error Same Data Invalid"));
            });
        }
    }
}

function deleteObject(objectName, id)
{
    correct = confirm(getLangMsj("Are You Sure to delete the ") + getLangMsj(objectName) + 
                      getLangMsj(" No.") + id + "?");
    
    if (objectName === 'church')
    {
        if (correct)
        {
            //Get the data for insert in the database
            var datosEnv  = '../JS/Ajax/deleteChurch.php?idChurch=' + id;

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    if (ajax.responseText.indexOf("KO") !== -1)
                    {
                        alert(getLangMsj("Error Delete The Church, First Delete the Rector from that church"));
                    }
                    else //OK
                    {
                        alert(getLangMsj("Sucess Delete"));
                        window.location.href = "churchMenu.php";
                    }
                }
            }

            //Envio de datos al servidor
            ajax.open("GET",datosEnv,true);
            ajax.send();
        }
    }
    else if (objectName === 'rector')
    {
        if (correct)
        {
            //Get the data for insert in the database
            var datosEnv  = '../JS/Ajax/deleteRector.php?idRector=' + id;

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    if (ajax.responseText.indexOf("KO") !== -1)
                    {
                        alert(getLangMsj("Error Delete The ") + getLangMsj("Rector"));
                    }
                    else //OK
                    {
                        alert(getLangMsj("Sucess Delete"));
                        window.location.href = "rectorMenu.php";
                    }
                }
            }

            //Envio de datos al servidor
            ajax.open("GET",datosEnv,true);
            ajax.send();
        }
    }
    else if (objectName === 'baptism')
    {
        if (correct)
        {
            //Get the data for insert in the database
            var datosEnv  = '../JS/Ajax/deleteBaptism.php?idBaptism=' + id;

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    if (ajax.responseText.indexOf("KO") !== -1)
                    {
                        alert(getLangMsj("Error Delete The Baptism"));
                    }
                    else //OK
                    {
                        alert(getLangMsj("Sucess Delete"));
                        window.location.href = "baptismMenu.php";
                    }
                }
            }

            //Envio de datos al servidor
            ajax.open("GET",datosEnv,true);
            ajax.send();
        }
    }
    else if (objectName === 'communion')
    {
        if (correct)
        {
            //Get the data for insert in the database
            var datosEnv  = '../JS/Ajax/deleteCommunion.php?idCommunion=' + id;

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    if (ajax.responseText.indexOf("KO") !== -1)
                    {
                        alert(getLangMsj("Error Delete The Communion"));
                    }
                    else //OK
                    {
                        alert(getLangMsj("Sucess Delete"));
                        window.location.href = "communionMenu.php";
                    }
                }
            }

            //Envio de datos al servidor
            ajax.open("GET",datosEnv,true);
            ajax.send();
        }
    }
    else if (objectName === 'confirmation')
    {
        if (correct)
        {
            //Get the data for insert in the database
            var datosEnv  = '../JS/Ajax/deleteConfirmation.php?idConfirmation=' + id;

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    if (ajax.responseText.indexOf("KO") !== -1)
                    {
                        alert(getLangMsj("Error Delete The Confirmation"));
                    }
                    else //OK
                    {
                        alert(getLangMsj("Sucess Delete"));
                        window.location.href = "confirmationMenu.php";
                    }
                }
            }

            //Envio de datos al servidor
            ajax.open("GET",datosEnv,true);
            ajax.send();
        }
    }
    else if (objectName === 'marriage')
    {
        if (correct)
        {
            //Get the data for insert in the database
            var datosEnv  = '../JS/Ajax/deleteMarriage.php?idMarriage=' + id;

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    if (ajax.responseText.indexOf("KO") !== -1)
                    {
                        alert(getLangMsj("Error Delete The Marriage"));
                    }
                    else //OK
                    {
                        alert(getLangMsj("Sucess Delete"));
                        window.location.href = "marriageMenu.php";
                    }
                }
            }

            //Envio de datos al servidor
            ajax.open("GET",datosEnv,true);
            ajax.send();
        }
    }
    else if (objectName === 'proof')
    {
        if (correct)
        {
            //Get the data for insert in the database
            var datosEnv  = '../JS/Ajax/deleteProof.php?idProof=' + id;

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    if (ajax.responseText.indexOf("KO") !== -1)
                    {
                        alert(getLangMsj("Error Delete The Proof"));
                    }
                    else //OK
                    {
                        alert(getLangMsj("Sucess Delete"));
                        window.location.href = "proofMenu.php";
                    }
                }
            }

            //Envio de datos al servidor
            ajax.open("GET",datosEnv,true);
            ajax.send();
        }
    }
    else if (objectName === 'defuntion')
    {
        if (correct)
        {
            //Get the data for insert in the database
            var datosEnv  = '../JS/Ajax/deleteDefuntion.php?idDefuntion=' + id;

            var ajax = new XMLHttpRequest();

            //Revision del objeto funcionando
            ajax.onreadystatechange = function() 
            {
                if (ajax.readyState == 4 && ajax.status == 200) 
                {
                    if (ajax.responseText.indexOf("KO") !== -1)
                    {
                        alert(getLangMsj("Error Delete The Defuntion"));
                    }
                    else //OK
                    {
                        alert(getLangMsj("Sucess Delete"));
                        window.location.href = "defuntionMenu.php";
                    }
                }
            }

            //Envio de datos al servidor
            ajax.open("GET",datosEnv,true);
            ajax.send();
        }
    }
}

function newMessage()
{
    correct     = true;
    bodyMessage = $("#messageBody").val();

    if (bodyMessage === '')
    {
        $('#labelBtn').css('color', 'red');
        correct = false;
    }
    else
    {
        $('#labelBtn').css('color', 'gray');
    }

    console.log(bodyMessage);

    if (correct)
    {
        //Get The id from the page
        x = window.location.toString();
        x = x.substring(x.indexOf("id=") + 3);

        $.ajax
        ({
            data: {
                    'idTo'                : x ,
                    'bodyMessage'         : bodyMessage,
                  },

            type: "POST",
            url: '../JS/Ajax/newMessage.php',
        })
        .done(function( data, textStatus, jqXHR ) 
        {
            window.location.reload();
        })
        .fail(function( jqXHR, textStatus, errorThrown ) 
        {
            alert(getLangMsj("Error Same Data Invalid"));
        });
    }
}



function sha1(str) 
{
  //  discuss at: http://phpjs.org/functions/sha1/
  // original by: Webtoolkit.info (http://www.webtoolkit.info/)
  // improved by: Michael White (http://getsprink.com)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //    input by: Brett Zamir (http://brett-zamir.me)
  //  depends on: utf8_encode
  //   example 1: sha1('Kevin van Zonneveld');
  //   returns 1: '54916d2e62f65b3afa6e192e6a601cdbe5cb5897'

  var rotate_left = function(n, s) {
    var t4 = (n << s) | (n >>> (32 - s));
    return t4;
  };

  var cvt_hex = function(val) {
    var str = '';
    var i;
    var v;

    for (i = 7; i >= 0; i--) {
      v = (val >>> (i * 4)) & 0x0f;
      str += v.toString(16);
    }
    return str;
  };

  var blockstart;
  var i, j;
  var W = new Array(80);
  var H0 = 0x67452301;
  var H1 = 0xEFCDAB89;
  var H2 = 0x98BADCFE;
  var H3 = 0x10325476;
  var H4 = 0xC3D2E1F0;
  var A, B, C, D, E;
  var temp;

  var str_len = str.length;

  var word_array = [];
  for (i = 0; i < str_len - 3; i += 4) {
    j = str.charCodeAt(i) << 24 | str.charCodeAt(i + 1) << 16 | str.charCodeAt(i + 2) << 8 | str.charCodeAt(i + 3);
    word_array.push(j);
  }

  switch (str_len % 4) {
    case 0:
      i = 0x080000000;
      break;
    case 1:
      i = str.charCodeAt(str_len - 1) << 24 | 0x0800000;
      break;
    case 2:
      i = str.charCodeAt(str_len - 2) << 24 | str.charCodeAt(str_len - 1) << 16 | 0x08000;
      break;
    case 3:
      i = str.charCodeAt(str_len - 3) << 24 | str.charCodeAt(str_len - 2) << 16 | str.charCodeAt(str_len - 1) <<
        8 | 0x80;
      break;
  }

  word_array.push(i);

  while ((word_array.length % 16) != 14) {
    word_array.push(0);
  }

  word_array.push(str_len >>> 29);
  word_array.push((str_len << 3) & 0x0ffffffff);

  for (blockstart = 0; blockstart < word_array.length; blockstart += 16) {
    for (i = 0; i < 16; i++) {
      W[i] = word_array[blockstart + i];
    }
    for (i = 16; i <= 79; i++) {
      W[i] = rotate_left(W[i - 3] ^ W[i - 8] ^ W[i - 14] ^ W[i - 16], 1);
    }

    A = H0;
    B = H1;
    C = H2;
    D = H3;
    E = H4;

    for (i = 0; i <= 19; i++) {
      temp = (rotate_left(A, 5) + ((B & C) | (~B & D)) + E + W[i] + 0x5A827999) & 0x0ffffffff;
      E = D;
      D = C;
      C = rotate_left(B, 30);
      B = A;
      A = temp;
    }

    for (i = 20; i <= 39; i++) {
      temp = (rotate_left(A, 5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff;
      E = D;
      D = C;
      C = rotate_left(B, 30);
      B = A;
      A = temp;
    }

    for (i = 40; i <= 59; i++) {
      temp = (rotate_left(A, 5) + ((B & C) | (B & D) | (C & D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff;
      E = D;
      D = C;
      C = rotate_left(B, 30);
      B = A;
      A = temp;
    }

    for (i = 60; i <= 79; i++) {
      temp = (rotate_left(A, 5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff;
      E = D;
      D = C;
      C = rotate_left(B, 30);
      B = A;
      A = temp;
    }

    H0 = (H0 + A) & 0x0ffffffff;
    H1 = (H1 + B) & 0x0ffffffff;
    H2 = (H2 + C) & 0x0ffffffff;
    H3 = (H3 + D) & 0x0ffffffff;
    H4 = (H4 + E) & 0x0ffffffff;
  }

  temp = cvt_hex(H0) + cvt_hex(H1) + cvt_hex(H2) + cvt_hex(H3) + cvt_hex(H4);
  return temp.toLowerCase();
}
