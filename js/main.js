console.log("main js loaded");
// get needed elements
let theform = document.querySelector("form.comment-form");
let thecomment = document.querySelector(".comment-form textarea");
let hiddeninput = document.querySelector(".comment-form input");
let commentsdiv = document.querySelector(".comments");
let commentcard = document.querySelectorAll(".card");

// add event listener, prevent default submission and get
//textarea value

theform.addEventListener("submit", function(event) {
  event.preventDefault();
  let comment = thecomment.value;
  let postid = hiddeninput.value.split("=");
  let theaction = "function/ajaxmanager.php";
  //console.log(comment, postid[1]);
  commentAjax(comment, postid[1], theaction)
  theform.reset();
})

// // commentcard.forEach((card, i) => {
// //   card.addEventListener("click", function(e) {
// //     e.preventDefault();
// //     console.log("click");
// //     if(e.target.classList.contains("delete-comment")){
// //       console.log("delete");
// //       let par = e.target.parentNode.parentNode.parentNode;
// //       console.log(par);
// //       par.classList.add("shrinkStart");
// //       setTimeout(function(){
// //         par.classList.add("shrinkFinish");
// //       },100);
// //     }
// //     let theaction = "function/ajaxmanager.php";
// //     let xhr = new XMLHttpRequest();
// //     xhr.open("POST", theaction, true);
// //   // to use the post method we must set the request headers
// //   // depending on the form data being sent
// //     xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// //     xhr.onload = function() {
// //     if(this.status == 200) {
// //       //console.log(this.responseText);
// //       //let output = JSON.parse(this.responseText);
// //       //console.log(output);
// //     }
// //   }

//     console.log(e);
//   })

// });


// ajax request

function commentAjax(comment, postid, theaction) {

  let xhr = new XMLHttpRequest();
  xhr.open("POST", theaction, true);
  // to use the post method we must set the request headers
  // depending on the form data being sent
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  
  xhr.onload = function() {
    console.log(this.responseText);
    if(this.status == 200) {
      let new_comment = JSON.parse(this.responseText);
      outputNewComment(new_comment);
    }
  }

  xhr.send("comment="+comment+"&post_id="+postid);
}

// General function
function outputNewComment(output) {
  console.log(output);

  let commentBox =
  `<div class='card'>
    <div class='card-body'>
      <div class='row'>
          <div class='col-md-2'>
              <img src=${output.user_ava} class='img img-rounded img-fluid'/>
          </div>
          <div class='col-md-10'>
                  <h5 class='float-left'><strong>${output.user_name}</strong></h5>
                  <p class='float-right'>${output.date_modified}</p>
             <div class='clearfix'></div>
              <p>${output.comment}</p><p>
      <a href='' class='edit-comment float-right btn btn-outline-warning ml-2'> <i class='fa fa-edit'></i> Edit</a>
      <a href='function/commentmanager.php?delete-id=${output.ID}' class='delete-comment float-right btn text-white btn-danger'> <i class='fa fa-trash'></i> Delete</a>
  </p>
    </div>
  </div>
</div>
</div>`;

  theform.insertAdjacentHTML("afterend", commentBox);

}
