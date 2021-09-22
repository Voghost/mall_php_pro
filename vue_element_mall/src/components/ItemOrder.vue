<template>
  <!--订单状态-->
  <el-tabs :tab-position="tabPosition" style="height: auto;" tabindex="/About">
    <el-tab-pane label="未支付">
      <List :status='0'></List>
    </el-tab-pane>
    <el-tab-pane label="待发货">
      <List :status='1'></List>
    </el-tab-pane>
    <el-tab-pane label="已发货">
      <List :status='2'></List>
    </el-tab-pane>
    <el-tab-pane label="待评价">
      <List :status='3'></List>
    </el-tab-pane>
    <el-tab-pane label="退款中">
      <RequestRefund></RequestRefund>
    </el-tab-pane>
    <el-tab-pane label="退款成功">
      <RequestSuccess></RequestSuccess>
    </el-tab-pane>
    <el-tab-pane label="退款失败">
      <RequestFailed></RequestFailed>
    </el-tab-pane>
  </el-tabs>

</template>

<script>
import List from "@/components/List";
import RequestRefund from "@/components/RequestRefund";
import RequestFailed from "@/components/RequestFailed";
import RequestSuccess from "@/components/RequestSuccess";
export default {
  name: "ItemOrder",
  data() {
    return {
      tabPosition: 'left'
    };
  },
  components:{
    RequestRefund,
    RequestFailed,
    RequestSuccess,
    List
  },
}
</script>

<style scoped>

</style>