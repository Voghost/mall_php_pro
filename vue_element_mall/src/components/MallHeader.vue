<template>
  <!--标题头部-->
  <el-header class="main" height="30px">
    <div class="left">
      <el-link href="#" class="link"><i class="el-icon-user">登录</i></el-link>
      <el-divider direction="vertical"></el-divider>
      <el-link href="#"><i class="el-icon-top-right"></i>注册</el-link>
      <el-divider direction="vertical"></el-divider>
      <el-link href="#">微信登陆</el-link>
    </div>
    <div class="right">
      <el-link href="#" class="link"><i class="el-icon-s-custom">我的资料</i></el-link>
      <el-divider direction="vertical"></el-divider>
      <el-link href="#"><i class="el-icon-c-scale-to-original">我的订单</i></el-link>
      <el-divider direction="vertical"></el-divider>
      <el-link href="#"><i class="el-icon-shopping-cart-1"></i>购物车</el-link>
    </div>
  </el-header>
</template>

<script>
export default {
  name: "MallHeader",
}
</script>

<style scoped>
.main {
  min-width: 800px;
  width: 100%;
  position: fixed;
  top: 0;
  background-color: #f5f5f5;
  z-index: 99;
}

.link {
  margin-left: 15px;
}

.left {
  float: left;
  height: 30px;
  width: 240px;
  line-height: 30px;
  margin-left: 80px;
}

.right {
  float: right;
  height: 30px;
  width: 400px;
  line-height: 30px;
}

</style>
