<template>
  <!--标题头部-->
  <el-header class="main" height="30px">

    <div class="left" v-if="Object.keys(userInfo).length === 0">
      <el-link href="/Login_Register" class="link"><i class="el-icon-user">登录</i></el-link>
      <el-divider direction="vertical"></el-divider>
      <el-link href="/Login_Register"><i class="el-icon-top-right"></i>注册</el-link>
    </div>
    <div class="left" v-if="Object.keys(userInfo).length > 0">
      <el-link href=""> 欢迎您 {{ userInfo.user_name }}</el-link>
      <el-divider direction="vertical"></el-divider>
      <el-link href="/"><i class="el-icon-top-right"></i>首页</el-link>
    </div>

    <div class="right">
      <el-link href="/AboutMe" class="link"><i class="el-icon-s-custom">我的资料</i></el-link>
      <el-divider direction="vertical"></el-divider>
      <el-link href="#"><i class="el-icon-c-scale-to-original">我的订单</i></el-link>
      <el-divider direction="vertical"></el-divider>
      <el-link href="#"><i class="el-icon-shopping-cart-1"></i>购物车</el-link>
      <el-divider direction="vertical"></el-divider>
      <el-link @click="logout"><i class="el-icon-shopping-cart-1">注销</i></el-link>
    </div>

  </el-header>
</template>

<script>
export default {
  name: "MallHeader",
  data() {
    return {
      "userInfo": {},
    }
  },
  created() {
    this.userInfo = this.$store.state.userInfo;
    console.log("info", this.userInfo);
  },
  methods: {
    logout() {
      this.$store.dispatch("logout");
      this.$router.push({
        path: '/'
      })
    }
  }

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
