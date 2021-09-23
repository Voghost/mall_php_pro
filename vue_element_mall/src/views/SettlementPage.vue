<template>
  <el-container direction="vertical">
    <MallHeader></MallHeader>
    <ThingTittle style="box-shadow: rgba(0,0,0,0.3) 0 0 3px"></ThingTittle>
      <settlement-card :cart_id="cart_id"></settlement-card>
  </el-container>
</template>

<script>
import SettlementCard from "../components/SettlementCard";
import ThingTittle from "../components/ThingTittle";
import MallHeader from "../components/MallHeader";
export default {
  name: "SettlementPage",
  components: {MallHeader, SettlementCard, ThingTittle},
  data(){
    return{
      cart_id:[],
    }
  },
  created() {
    this.cart_id=this.$route.query.cart_id;

  }
}
</script>

<style scoped>

</style>