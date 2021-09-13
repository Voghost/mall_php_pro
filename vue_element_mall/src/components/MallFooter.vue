<template>
  <el-footer class="" style="margin-top: 80px; height: 250px; background-color: #282828;">
    <el-row type="flex" justify="center" style="width: 100%; margin-top: 50px; color: rgba(255,255,255,0.54)">
      <el-col :span="4" class="" style="height: 180px;">
        <div class="title">
          <i class="el-icon-service"></i>
          服务保障
        </div>
        <ul class="content">
          <li>正品保证</li>
          <li>X天无理由退换</li>
          <li>退货返运费</li>
          <li>XX小时客户服务</li>
        </ul>
      </el-col>
      <el-col :span="4" class="">
        <div class="title">
          <i class="el-icon-money"></i>
          支付方式
        </div>
        <ul class="content">
          <li>公司转帐</li>
          <li>货到付款</li>
          <li>在线支付</li>
          <li>分期付款</li>
        </ul>
      </el-col>
      <el-col :span="4" class="">
        <div class="title">
          <i class="el-icon-truck"></i>
          物流配送
        </div>
        <ul class="content">
          <li></li>
          <li>免运费</li>
          <li>海外配送</li>
          <li>EMS</li>
          <li>211限时达</li>
        </ul>
      </el-col>
      <el-col :span="8" class="" style=" text-align: center">
        <div class="shop" style="font-size: 60px; margin-top: 30px;">
          <i class="el-icon-shopping-bag-2"></i>
        </div>
        <el-link style="margin-top: 30px;">京ICP备11041704号</el-link>
      </el-col>
    </el-row>
  </el-footer>
</template>

<script>
export default {
  name: "MallFooter"
}
</script>

<style scoped>

</style>
