<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../../css/common/reset.css">
  <link rel="stylesheet" href="../../css/common/pay_info.min.css">
  <script src="../../js/flexible.min.js"></script>
  <title>待打款</title>
</head>

<body>
  <div id="pay">
    <div class="form-group">
      <div class="form-item">
        <div class="text">待收款人</div>
        <div class="value">中俄混血儿</div>
      </div>
      <div class="form-item">
        <div class="text">待打款金额</div>
        <div class="value">
          <i class="letter">¥</i>
          <span class="price">729</span>
        </div>
      </div>
    </div>
    <div class="content-wrapper">
      <div class="content-box">
        <div class="title">收款人二维码</div>
        <div class="content">
          <img class="content__img" src="../../images/userInfo/test-qrcode.png" alt="">
        </div>
      </div>
      <div class="content-box">
        <div class="title">上传打款证明</div>
        <div class="content">
          <img class="content__img" src="../../images/pay/icon-add.png" alt="">
        </div>
      </div>
      <div class="content-box">
        <div class="title">打款备注</div>
        <div class="content">
          <textarea class="content__textarea" placeholder="请填写备注"></textarea>
        </div>
      </div>
    </div>
    <button class="submit-btn center-block" type="button">提交</button>
  </div>
</body>

<script src="../../js/jquery.min.2.1.1.js"></script>
<script src="../../js/common.js"></script>

</html>