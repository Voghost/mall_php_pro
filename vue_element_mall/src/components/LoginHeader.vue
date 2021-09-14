<template>
  <!--标题头部-->
  <el-header class="main" height="30px">
    <div class="left">
      <el-popover
          placement="top-start"
          title="用户信息:"
          width="500px"
          trigger="hover">
        <el-table :data="adminData" style="width: 100%">
          <el-table-column width="150" prop="adminImages" property="date" label="照片"></el-table-column>
          <el-table-column width="100" prop="adminName" property="name" label="姓名"></el-table-column>
        </el-table>
        <a slot="reference" style="font-size: 14px;color:#606266;">用户名字</a>
      </el-popover>
      <el-divider direction="vertical"></el-divider>
      <el-link href="#"><i class="el-icon-top-right"></i>首页</el-link>
      <el-divider direction="vertical"></el-divider>
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
  name: "LoginHeader",
  data() {
    return {
      adminData: [{
        adminImages:"123",
        adminName: '王小虎',
      }]
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