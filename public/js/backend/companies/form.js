$(function () {
    // init: side menu for current page
    $('li#menu-companies').addClass('menu-open active');
    $('li#menu-companies').find('.treeview-menu').css('display', 'block');
    $('li#menu-companies').find('.treeview-menu').find('.add-companies a').addClass('sub-menu-active');

    $('#user-form').validationEngine('attach', {
        promptPosition : 'topLeft',
        scroll: false
    });

    // init: show tooltip on hover
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    // show password field only after 'change password' is clicked
    $('#reset-button').click(function (e) {
        $('#reset-field').removeClass('hide');
        $('#show-password-check').removeClass('hide');
        // to always uncheck the checkbox after button click
        $('#show-password').prop('checked', false);
    });

    // toggle password in plaintext if checkbox is selected
    $("#show-password").click(function () {
        $(this).is(":checked") ? $("#password").prop("type", "text") : $("#password").prop("type", "password");
    });
});




// $(document).ready(function (){
//     $(#searchPostcode).click(function (e) {
//         e.preventdefault();

//         // var postcode = $("input[name=display_postcode]").val();
//         $.ajax({
//             type: "POST",
//             url : "{{ route('companies.add')}}",
//             data : {
//                 postcode : $("#postcode").val()
//             }
//         })
//     })
// })



 // $(function checkFileDetails() {
 //        var fi = document.getElementById('file');
 //        if (fi.files.length > 0) {    
           
 //            for (var i = 0; i <= fi.files.length - 1; i++) {
 //                var fileName, fileExtension, fileSize, fileType, dateModified;

 //                fileName = fi.files.item(i).name;
 //                fileExtension = fileName.replace(/^.*\./, '');

 //                if (fileExtension == 'png' || fileExtension == 'jpg' || fileExtension == 'jpeg') {
 //                   readImageFile(fi.files.item(i));
 //                }
 //                else {
                        
 //                    fileSize = fi.files.item(i).size;
 //                    fileType = fi.files.item(i).type;
 //                    dateModified = fi.files.item(i).lastModifiedDate; 

 //                    document.getElementById('imageInfo').innerHTML =
 //                        document.getElementById('imageInfo').innerHTML + '| ' +
 //                            'Name: <b>' + fileName + '</b> |' +
 //                            'File Extension: <b>' + fileExtension + '</b> |' +
 //                            'Size: <b>' + Math.round((fileSize / 1024)) + '</b> KB |' +
 //                            'Type: <b>' + fileType + '</b>' +
 //                }
 //            }

 //            // GET THE IMAGE WIDTH AND HEIGHT USING fileReader() API.

 //            function readImageFile(file) {
 //                var imageField = document.getElementById("image-field")
 //                var reader = new FileReader(); // CREATE AN NEW INSTANCE.

 //                reader.onload = function (e) {
 //                    if (reader.readyState === 2) {
 //                    var img = new Image();      
 //                    img.src = e.target.result;

 //                    img.onload = function () {
 //                        var w = this.width;
 //                        var h = this.height;

 //                        document.getElementById('imageInfo').innerHTML =
 //                            document.getElementById('imageInfo').innerHTML + '<br /> ' +
 //                                'Name : <b>' + file.name + '</b> |' +
 //                                'File Size : <b>' + Math.round((file.size / 1024)) + '</b> KB |' +
 //                                'Size : <b>' + w + 'px x ' + h + 'px</b> '
 //                    }
 //                    imageField.src = reader.result;
 //                }

 //                };
 //                reader.readAsDataURL(file);
 //            }
 //        }
 //    }


// $("#searchPostcode").on("click", function(){
//     var postcode = document.getElementById("postcode").value;

//     $.ajax({
//         url:window.location.href="{{ route('companies.add')}}"+postcode
//     });
// });
