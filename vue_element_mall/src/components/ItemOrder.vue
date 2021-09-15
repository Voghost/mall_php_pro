<template>
  <!--订单状态-->
  <el-tabs :tab-position="tabPosition" style="height: auto;">
    <el-tab-pane label="全部订单">
      <ItemList></ItemList><!--订单状态-->
    </el-tab-pane>
    <el-tab-pane label="待付款">
      <NopayList></NopayList>
    </el-tab-pane>
    <el-tab-pane label="待收货">
      <PaidList></PaidList>
    </el-tab-pane>
    <el-tab-pane label="待评价">
      <ReceivedList></ReceivedList>
    </el-tab-pane>
  </el-tabs>

</template>

<script>
import ItemList from "./ItemList";
import NopayList from "@/components/NopayList";
import PaidList from "@/components/PaidList";
import ReceivedList from "@/components/ReceivedList";
export default {
  name: "ItemOrder",
  components: {
    ReceivedList,
    ItemList,
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