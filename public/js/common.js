$(function () {

  showModal("#show_modal");
  closeModal(".close_modal");


  // 显示弹框
  function showModal(ele) {
    $(ele).on("click", function () {
      $(".modal").fadeIn(200)
    });
  }

  // 关闭弹框
  function closeModal(ele) {
    $(ele).on("click", function () {
      $(".modal").fadeOut(200)
    })
  }

  $(".icon-back").on("click", function () {
      window.history.go(-1);
  })

})