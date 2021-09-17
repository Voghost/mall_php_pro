<template>
  <!--订单状态-->
  <el-tabs :tab-position="tabPosition" style="height: auto;">
    <el-tab-pane label="待付款">
      <NopayList></NopayList>
    </el-tab-pane>
    <el-tab-pane label="待收货">
      <PaidList></PaidList>
    </el-tab-pane>
    <el-tab-pane label="待评价">
      <ReceivedList></ReceivedList>
    </el-tab-pane>
    <el-tab-pane label="已完成">
      <CompleteOrder></CompleteOrder>
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
import NopayList from "@/components/NopayList";
import PaidList from "@/components/PaidList";
import ReceivedList from "@/components/ReceivedList";
import CompleteOrder from "@/components/CompleteOrder";
import RequestRefund from "@/components/RequestRefund";
import RequestFailed from "@/components/RequestFailed";
import RequestSuccess from "@/components/RequestSuccess";
export default {
  name: "ItemOrder",
  components: {
    RequestSuccess,
    RequestFailed,
    RequestRefund,
    CompleteOrder,
    ReceivedList,
    NopayList,
    PaidList,
  },
  data() {
    return {
      tabPosition: 'left'
    };
  }
}
</script>

<style scoped>

</style>