((d)=>{
  Elearn ={
      HideDisplay:(HideObj,DisplayObj)=>{
        if(HideObj == DisplayObj)return false;
        HideObj.classList.add("w3-hide");
        DisplayObj.classList.remove("w3-hide");
        return true;
      },
      LoadingMk:'<div class="loading fadeInUp animate-slow animate-delay-1 animate-fill-both"><i class="mbri-setting3 fa fa-spin"></i></div>',
      Filler:(PageID,res)=>{
        //get location to load content
        var contentloc = _(PageID).querySelectorAll(".nuco-body,.nuco-title");
        if(contentloc.length > 0){
            contentloc.forEach((cont,Index)=>{
                //cont.innerHTML = Elearn.LoadingMk;
                cont.innerHTML = res[Index];
                //return cont;
            })
        }
      },

      LastPage:null,

      Back:bkbtn=>{
        Elearn.PauseVideos();
        bkbtn.parentElement.parentElement.parentElement.removeChild(bkbtn.parentElement.parentElement)
      },

      PauseVideos:()=>{
//check if video exist in page
var videos = _('nuco-main-cont').firstElementChild.querySelectorAll("video");
//alert(videos.length);
if(videos.length > 0){
    videos.forEach(vid=>{
        vid.pause();
    })
}
      },
      
      //New load page to manage nuco for now
      Load:(PageID,Data)=>{
          Elearn.PauseVideos();
          //check if current page exist
          
          var pg = _(PageID);
          if(_.IsFound(pg)){
            PageID += "_"+Data;
          }
        //get the template
        _('nuco-main-cont').insertAdjacentHTML("afterbegin",_('nuco-page-template').innerHTML.replace('{{PageID}}',PageID));
        Elearn.Loader("script/loader.php",{Data:Data,PageID:PageID}).then((res)=>{
            //alert(res);
            Elearn.Filler(PageID,res);
            Elearn.LastPage = PageID;
        }).catch((er)=>{
            Elearn.Filler(PageID,["",er]);
            Elearn.LastPage = PageID;
        });
      },

      LoadPage:(curPage,PageID,Script,Data)=>{
        if(Elearn.HideDisplay(_(curPage),_(PageID))){
            if(typeof Data.Key != "undefined" && Data.Key == 0)return;
            Elearn.Filler(PageID,[Elearn.LoadingMk,Elearn.LoadingMk]);
            Elearn.Loader(Script,Data).then((res)=>{
                //alert(res);
                Elearn.Filler(PageID,res);
            }).catch((er)=>{
                Elearn.Filler(PageID,["",er]);
            });
           }else{
               //alert("Already Displayed");
           }
      },
      Globals:{SchoolID:0,LevelID:0},

     HomeFrom:(curPage)=>{
         Elearn.HideDisplay(_(curPage),_('HomePage'));
     },
     SchoolFrom:(curPage)=>{
         Elearn.LoadPage(curPage,"SchoolPage","script/study.php",{});
     },
     ClassFrom:(curPage,SchoolID)=>{
        SchoolID = SchoolID || 0;
        Elearn.Globals.SchoolID = SchoolID;
        Elearn.LoadPage(curPage,"ClassPage","script/level.php",{Key:SchoolID});
     },
     TermFrom:(curPage,lvlID)=>{
        var Data={};
        if(typeof lvlID != "undefined"){
            Elearn.Globals.LevelID = lvlID;
            Data = {Key:lvlID,Key1:Elearn.Globals.SchoolID};
        }
        
        Elearn.LoadPage(curPage,"TermPage","script/term.php",Data);
     },
     SubjectFrom:(curPage,TermID)=>{
        var Data={};
        if(typeof TermID != "undefined"){
        Elearn.Globals.TermID = TermID;
        Data = {LevelID:Elearn.Globals.LevelID,StudyID:Elearn.Globals.SchoolID,SemID:TermID}
        }
        Elearn.LoadPage(curPage,"SubjectPage","script/subject.php");
        
     },
     LearnFrom:(curPage,SubjectID)=>{
        Elearn.HideDisplay(_(curPage),_('LearnPage'));   
     },
     Loader:(page,data)=>{
         return new Promise((resolve,reject)=>{
            _.Post({
                Action:page,
                Data:data,
                OnComplete:(res)=>{
                    //alert(res);
                    res = JSON.parse(res);
                    //check if my error
                    if(res[1].substr(0,1) == "#"){
                        reject(res[1].substr(1));
                    }else{
                        resolve(res);
                    }
                },
                OnError:(res)=>{
                    reject(res);
                }
            })
         })
     }
 }
})(window.document);