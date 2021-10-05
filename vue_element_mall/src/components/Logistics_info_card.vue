<template>
  <el-timeline :reverse="reverse">
    <el-timeline-item
        v-for="(activity, index) in logistics_info"
        :key="index"
        :timestamp="activity.timestamp"
        color="blue">
      {{ activity.content }}
    </el-timeline-item>
  </el-timeline>
</template>

<script>
export default {
  name: "Logistics_info_card",
  data() {
    return {
      reverse: true,
      order_id:123,
      order_number:1223,
      logistics_info: [{
        content: '已送达',
        timestamp: '2018-04-15'
      }, {
        content: '正在派送',
        timestamp: '2018-04-13'
      }, {
        content: '已接受订单',
        timestamp: '2018-04-11'
      }]
    };
  }
};
</script>

<style scoped>

</style>