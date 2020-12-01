var Club = {
    
    SignUp:function(){
        var fn = _.Trim(_('fullname').value);
        var nn = _.Trim(_('nickname').value);
        var pn = _.Trim(_('phone').value);
        var em = _.Trim(_('email').value);
        var ad = _.Trim(_('addr').value);
        if(fn == "" || nn == "" || pn == "" || em == "" || ad == ""){
            alert("Invalid Entering, all field are required");
            return;
        }

        if(!_.IsPhoneNumber(pn)){
            alert("Invalid Phone Number Supplied");
            return;
        }

        if(!_.IsEmail(em)){
            alert("Invalid Email Address Supplied");
            return;
        }

        var lectImg = _('MPassport');
        var data = {};
          if(!_.IsFound(lectImg)){
            //alert("Set your Photograph by Double-Click the Photograph Box");
          //return;
          data = {"fn":fn,"nn":nn,"pn":pn,"em":em,"ad":ad};
          }else{
            data = {"fn":fn,"nn":nn,"pn":pn,"em":em,"ad":ad,"MPassport":"?"};  
          }

        _.Post({
            Action:"script/addmember.php",
            Data:data,
            OnComplete:function(res){
                //get the first character
                var fchar = res.substr(0,1);
                if(fchar == "#"){ //completed
                  alert(res.substr(1));
                  _('fullname').value = "";
                   _('nickname').value = "";
                    _('phone').value = "";
                    _('email').value = "";
                        _('addr').value = "";
                        _('formpopimg').src = "images/formpop/img.png";
                  _('formpopup').classList.add('w3-hide');
                }else{
                    alert(res);
                }
            },
            OnError:function(res){
                alert(res);
            },
            OnAbort:function(res){
                alert(res);
            }
        });
       // var ad = _('addr').value;
    },

    Login:function(){
        var umc = _.Trim(_('lumc').value);
        var nn = _.Trim(_('lnickname').value);
        if(nn == "" || umc == ""){
            alert("Your Nickname and UMC is compulsary");
            return;
        }
        _.Post({
            Action:"script/login.php",
            Data:{"nn":nn,"umc":umc},
            OnComplete:function(res){
                //get the first character
                //var fchar = res.substr(0,1);
                if(res == "#"){ //completed
                  //alert(res.substr(1));
                  _('lumc').value = "";
                   _('lnickname').value = "";
                    //redirect to order page
                    window.location = "order.php";
                }else{
                    alert(res);
                }
            },
            OnError:function(res){
                alert(res);
            },
            OnAbort:function(res){
                alert(res);
            }
        });
    }
}



var Nasa = {
    StartLoading:function(text,loadinobjid){
     text = typeof text == "undefined" || text == null?"Please wait, while we save your input ...":text;
     loadinobjid = typeof loadinobjid == "undefined"?"pageloader":loadinobjid;
     var loaderpage = _(loadinobjid);
     if(_.IsFound(loaderpage)){
         //get the text placeholder
         var loaderpagetxt = _('pageloader-txt');
         if(_.IsFound(loaderpagetxt))loaderpagetxt.innerHTML = text;
         loaderpage.classList.remove("w3-hide");
     }
    },
    StopLoading:function(loadinobjid){
        loadinobjid = typeof loadinobjid == "undefined"?"pageloader":loadinobjid;
        var loaderpage = _(loadinobjid);
        if(_.IsFound(loaderpage)){
            loaderpage.classList.add("w3-hide");
        }
    },
    ShowError:function(text){
    let errp =_('pageerr');
    if(_.IsFound(errp) && typeof text != "undefined"){
        errp.innerHTML = text;
        errp.classList.remove("w3-hide");
    }
    },
    HideError:function(){
        let errp =_('pageerr');
        if(_.IsFound(errp)){
            errp.classList.add("w3-hide");
        }  
    },
    Register1:function(){
        //make sure all fields are supplied
        var surname = _('nasa-surname');
        if(_.Trim(surname.value) == ""){surname.classList.add("iserr");return;}
        var firstname = _('nasa-firstname');
        if(_.Trim(firstname.value) == ""){firstname.classList.add("iserr");return;}
        var othername = _('nasa-othername');
        // if(_.Trim(othername.value) == ""){othername.classList.add("iserr");return;}
        var email = _('nasa-email');
        /* if(!_.IsPhoneNumber(pn)){
            alert("Invalid Phone Number Supplied");
            return;
        }

        if(!_.IsEmail(em)){
            alert("Invalid Email Address Supplied");
            return;
        } */
        _('pageloaderm').classList.remove('w3-hide');
        _('pageerr2').classList.add('w3-hide');
        if(_.Trim(email.value) == "" || !_.IsEmail(email.value)){email.classList.add("iserr");return;}
        var conemail = _('nasa-conemail');
        if(_.Trim(conemail.value) == "" || !_.IsEmail(conemail.value) || ConfirmEmail() == false){conemail.classList.add("iserr");return;}
        var phone = _('nasa-phone');
        if(_.Trim(phone.value) == "" || !_.IsPhoneNumber(phone.value)){phone.classList.add("iserr");return;}
        //send mail
        _.Post({
            Action:"script/register1.php",
            Data:{"sn":surname.value,"fn":firstname.value,"on":othername.value,"em":email.value,"pn":phone.value},
            OnComplete:function(res){
                _('pageloaderm').classList.add('w3-hide');
                //alert(res);
                var resobj = JSON.parse(res);
                if(typeof resobj['Error'] != "undefined"){
                    _('pageerr2').innerHTML = resobj['Error'];
                    _('pageerr2').classList.remove('w3-hide');
                    return;
                }
                _('reg1pg').classList.add('w3-hide');_('commespg').classList.remove('w3-hide');
            },
            OnError:function(res){
                _('pageloaderm').classList.add('w3-hide');
                _('pageerr2').innerHTML = res;
                    _('pageerr2').classList.remove('w3-hide');
            },
            OnAbort:function(res){
                _('pageloaderm').classList.add('w3-hide');
                _('pageerr2').innerHTML = res;
                    _('pageerr2').classList.remove('w3-hide');
            }
        });
        
       // _('reg1pg').classList.add('w3-hide');_('commespg').classList.remove('w3-hide');
    },
    CancelReg:function(){
        Nasa.StartLoading("Please wait, while we close your registration session");
        _.Post({
            Action:"script/cancelreg.php",
            Data:{},
            OnComplete:function(res){
                //alert(res);
                window.location = "./";
            },
            OnError:function(res){
                alert(res);
                Nasa.StopLoading();
            },
            OnAbort:function(res){
                alert(res);
                Nasa.StopLoading();
            }
        });
    },
    Register:function(form,lvl){
        Nasa.HideError();
        lvl = lvl || 2;
        var Datas = form.getElementsByClassName('NasaData');
        if(Datas != null && Datas.length > 0){
            var PData = {"RegLevel":lvl};
            
            for(let s=0; s<Datas.length; s++){
                let ival = Datas[s].value;
                if(Datas[s].tagName.toLowerCase() == "select")ival = Datas[s].options[Datas[s].selectedIndex].value;
                if(Datas[s].tagName.toLowerCase() == "img" && typeof _(Datas[s].id+"file") != "undefined")ival = "?";
                if(Datas[s].tagName.toLowerCase() == "table"){ //if table
                  //get all the rows
                  var rws = Datas[s].rows;
                  if(rws.length > 0){
                      var tbival = [];
                    //loop troug each row to get input data
                    for(let f=0;f<rws.length;f++){
                        let indrw = rws[f];
                        //get all the input elemets
                        let inptag = indrw.getElementsByTagName('input');
                        if(inptag.length < 1)continue;
                        var tbrw = {};
                        for(let d=0; d<inptag.length; d++){
                            let inp = inptag[d];
                            tbrw[inp.id] = inp.value;
                        }
                        tbival[tbival.length] = tbrw;
                        //alert(indrw.outerHTML);
                        //get the doc
                        var atagcol = indrw.getElementsByTagName('a');
                        if(atagcol.length > 0){
                            let atag = atagcol[0];
                        //alert(atag.length);
                        atagid = atag.id;
                        fileid = atagid.substr(3);
                        //check if file uploaded
                        if(typeof _(fileid) != "undefined"){
                            PData[fileid] = "?";
                        }
                        }
                        
                    }
                    ival = JSON.stringify(tbival);
                  }else{
                      ival = "";
                  }
                }
                if(Datas[s].required && _.Trim(ival) == ""){
                    Datas[s].classList.add('iserr');
                    return;
                }
                //if file
                if(ival == "?"){
                  PData[Datas[s].id+"file"] = ival;
                  PData[Datas[s].id] = "";
                }else{
                    PData[Datas[s].id] = ival;  
                }
                
            
            }
           // alert(JSON.stringify(PData));
            Nasa.StartLoading("Please wait, while we save your input ...");
            //alert(JSON.stringify(PData));
           // return;
            _.Post({
                Action:"script/register.php",
                Data:PData,
                OnComplete:function(res){
                    res = _.Trim(res);
                    let fval = res.substr(0,1);
                    if(fval == "#"){
                        Nasa.ShowError(res.substr(1));
                    }else{
                      _('maincontreg').innerHTML = res;
                    }
                    Nasa.StopLoading();
                    //window.location = "./";
                },
                OnError:function(res){
                    alert(res);
                    Nasa.StopLoading();
                },
                OnAbort:function(res){
                    alert(res);
                    Nasa.StopLoading();
                }
            });

            //Nasa.StopLoading();
        }
    },
    LoadLGA:function(sel){
        //get the selected value
        var stid = sel.options[sel.selectedIndex].value;
        Nasa.StartLoading("Loading Local Government Area ....");
        _.Post({
            Action:"script/lga.php",
            Data:{StateID:stid},
            OnComplete:function(res){
                _('LGA').innerHTML = res;
                Nasa.StopLoading();
                //window.location = "./";
            },
            OnError:function(res){
                alert(res);
                Nasa.StopLoading();
            },
            OnAbort:function(res){
                alert(res);
                Nasa.StopLoading();
            }
        });
    },
    AddRow:function(tb){
        var tbrow = tb.rows;
        lstrw = tbrow[tbrow.length - 1];
        var nwrw = lstrw.Cloner();
        //var atag = nwrw.getElementsByTagName('a')[0];
        //atag.innerHTML = '<i class="fas fa-upload"></i>  Upload';
        //atag.id = "el_"+tb.id+"_doc"+(tbrow.length);
       // atag.outerHTML = atag.outerHTML.replace("{FileID:'"+tb.id+"_doc"+(tbrow.length - 1)+"'","{FileID:'"+tb.id+"_doc"+(tbrow.length)+"'");
        
        

        //update the new input elements
        var inptag = nwrw.getElementsByTagName('input');
        for(let d=0; d<inptag.length; d++){
            let inp = inptag[d];
            if(inp.id == tb.id+"_inst"+(tbrow.length - 1)){
                inp.id = inp.id.replace("_inst"+(tbrow.length - 1),"_inst"+tbrow.length);
            }else if(inp.id == tb.id+"_qual"+(tbrow.length - 1)){
                inp.id = inp.id.replace("_qual"+(tbrow.length - 1),"_qual"+tbrow.length);
            }else if(inp.id == tb.id+"_date"+(tbrow.length - 1)){
                inp.id = inp.id.replace("_date"+(tbrow.length - 1),"_date"+tbrow.length);
            }
            inp.value = "";

        }
       
        tb.insertAdjacentElement('beforeend',nwrw);
        //alert(lstrw)
    },
    Finish:function(){
        
        Nasa.StartLoading("Loading Local Government Area ....");
        _.Post({
            Action:"script/finishreg.php",
            Data:{},
            OnComplete:function(res){
                res = _.Trim(res);
                let fval = res.substr(0,1);
                if(fval == "#"){
                    Nasa.ShowError(res.substr(1));
                }else{
_('maincontreg').innerHTML = res;
                }
                Nasa.StopLoading();
                //window.location = "./";
            },
            OnError:function(res){
                alert(res);
                Nasa.StopLoading();
            },
            OnAbort:function(res){
                alert(res);
                Nasa.StopLoading();
            }
        });
    },
    CloseCheck:function(){
        _('AppID').value = "";
        _('formpopupck').classList.add("w3-hide");
    },
    OpenCheck:function(){
        _('AppID').value = "";
        _('formpopupck').classList.remove("w3-hide");
    },
    CheckStatus:function(){
        _('pageerrck').classList.add('w3-hide');
        var tb = _('AppID');
        if(_.Trim(tb.value) == ""){
            tb.classList.add('iserr');
            return;
        }
        Nasa.StartLoading("Checking Registration Status ...","pageloaderck");
        _.Post({
            Action:"script/checkst.php",
            Data:{AppID:tb.value},
            OnComplete:function(res){
                res = _.Trim(res);
                let fval = res.substr(0,1);
                if(fval == "#"){
                    var errmsg  = _('pageerrck');
                    errmsg.innerHTML = res.substr(1);
                    errmsg.classList.remove('w3-hide');
                }else if(fval == "*"){ //if registration not complete
                  window.location = "?v="+res.substr(1);
                }else{
                    _('regckst').innerHTML = res;
                }
                Nasa.StopLoading("pageloaderck");
                //window.location = "./";
            },
            OnError:function(res){
                var errmsg  = _('pageerrck');
                    errmsg.innerHTML = res;
                    errmsg.classList.remove('w3-hide');
                Nasa.StopLoading("pageloaderck");
            },
            OnAbort:function(res){
                var errmsg  = _('pageerrck');
                    errmsg.innerHTML = res;
                    errmsg.classList.remove('w3-hide');
                Nasa.StopLoading("pageloaderck");
            }
        });
    },
    CheckCopon:function(payid){
        cupinp = _('nasa-cupon');
        var ucupon = _.Trim(cupinp.value)
        if(ucupon == ""){
            cupinp.classList.add('iserr'); return;
        }
        Nasa.StartLoading("Verifying Coupon ...","pageloader");
        _.Post({
            Action:"script/verifycupon.php",
            Data:{PayID:payid,UCupon:ucupon},
            OnComplete:function(res){
                res = _.Trim(res);
                let fval = res.substr(0,1);
                if(fval == "#"){
                    Nasa.ShowError(res.substr(1));
                }else{ //if no error - returns the 
                  window.location = "?v="+res;
                }
                Nasa.StopLoading("pageloader");
                //window.location = "./";
            },
            OnError:function(res){
                Nasa.ShowError(res)
                Nasa.StopLoading("pageloader");
            },
            OnAbort:function(res){
                Nasa.ShowError(res)
                Nasa.StopLoading("pageloader");
            }
        });
    }
}