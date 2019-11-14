<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/common/reset.css">
    <link rel="stylesheet" href="/public/css/userinfo/editinfo.min.css">

    <script src="/public/js/flexible.min.js"></script>
    <title>�༭����</title>
</head>

<body>
<div id="user">
    <div class="form-item">
        <div class="form-text">ͷ��</div>
        <div class="form-inp">
            <img class="fi_image" src="/public/images/userInfo/icon-avatar.png" alt="">
            <input type="file" class="fi-avatar__file" id="upload_avatar">
        </div>
    </div>
    <div class="form-item">
        <div class="form-text">�ǳ�</div>
        <div class="form-inp">
            <input class="fi-text" type="text" value="�ж��Ѫ��">
        </div>
    </div>
    <div class="form-item">
        <{if $qrcode neq ""}>
        <div class="form-text">�տ��ά��</div>
        <!-- ���ϴ��տ��ά�� -->
        <div class="form-inp">
            <i class="icon-qrcode" id="show_modal"></i>
            <i class="icon-right"></i>
        </div>
        <{else}>
        <!-- δ�ϴ��տ��ά�� -->
        <div class="form-inp">
            <p class="fi-upload__p">�뾡���ϴ�</p>
            <i class="icon-right"></i>
            <input class="fi-qrcode__file" type="file" id="upload_qrcode">
        </div>
        <{/if}>
    </div>
</div>

<div class="modal">
    <div class="mask close_modal"></div>
    <div class="content">
        <!-- ���ʹ���ϴ������Ϊimg��ǩ����  -->
        <img class="c-rqcode__img" src="<{$qrcode}>" alt="">
        <p class="c-text__p">
            <a href="javascript:void(0)" onclick="uploadPhoto()">������Ǯ��ά��</a>
            <input type="file" id="photoFile" style="display: none;" onchange="upload()">
            <img id="preview_photo" src="" width="200px" height="200px">
        </p>
    </div>
</div>
</body>

<script src="/public/js/jquery.min.2.1.1.js"></script>
<script src="/public/js/common.js"></script>
<script>
    function uploadPhoto() {
        $("#photoFile").click();
    }

    /**
     * �ϴ�ͼƬ
     */
    function upload() {
        if ($("#photoFile").val() == '') {
            return;
        }
        var formData = new FormData();
        formData.append('pic', document.getElementById('photoFile').files[0]);
        $.ajax({
            url:"http://m.evyun.cn:12701/Frontend/Web/UUUploadPic?username=wolaiceshi&zz_userid=248478&zz_shellCode=%242y%2410%24o4IkxfHsJegI8aazuMrvOOme4m4xsGmSsBV9a32p1Trlk6aCXoUO6&zz_shellTime=5dcce893b0326&name=pic&type=1",
            type:"post",
            dataType: "json",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.code == 200) {
                    $(".c-rqcode__img").attr("src", data.data.path);
                    $("#productImg").val(data.data.path);
                } else {
                    alert(data.msg);
                }
            },
            error:function(data) {
                alert("�ϴ�ʧ��")
            }
        });
    }
</script>
</html>