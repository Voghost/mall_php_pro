<template>
  <el-container direction="vertical">
    <LoginHeader></LoginHeader>
    <ThingTittle style="box-shadow: rgba(0,0,0,0.3) 0 0 3px"></ThingTittle>
      <settlement-card :cart_id="cart_id"></settlement-card>
  </el-container>
</template>

<script>
import SettlementCard from "../components/SettlementCard";
import LoginHeader from "../components/LoginHeader";
import ThingTittle from "../components/ThingTittle";
export default {
  name: "SettlementPage",
  components: { SettlementCard, LoginHeader,ThingTittle},
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