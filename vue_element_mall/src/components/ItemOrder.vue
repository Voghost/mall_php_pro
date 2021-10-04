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
    <el-tab-pane label="已完成">
      <List :status='4'></List>
    </el-tab-pane>
    <el-tab-pane label="退款中">
      <List :refund='1'></List>
    </el-tab-pane>
    <el-tab-pane label="退款成功">
      <List :refund='2'></List>
    </el-tab-pane>
  </el-tabs>

</template>

<script>
import List from "@/components/List";

export default {
  name: "ItemOrder",
  data() {
    return {
      tabPosition: 'left'
    };
  },
  components:{
    List
  },
}
</script>

<style scoped>

</style>