<template>
  <div>
    <LoginHeader></LoginHeader>
    <ThingTittle style="box-shadow: rgba(0,0,0,0.3) 0 0 3px"></ThingTittle>
    <el-container   direction="vertical">
      <div class="main_content">
      <el-main class="main_box">
        <el-tabs :tab-position="tabPosition1" style="margin: 10px;" v-model="selectedTag" >
          <el-tab-pane label="账号资料" name="first">
            <UserData></UserData>
          </el-tab-pane>
          <el-tab-pane label="购物车" name="second">
            <CartCard></CartCard>
          </el-tab-pane>
          <el-tab-pane label="全部订单" name="third">
            <ItemOrder></ItemOrder>
          </el-tab-pane>
          <el-tab-pane label="账户信息修改" name="fourth">
            <el-tabs :tab-position="tabPosition2">
              <el-tab-pane label="基本信息修改">
                <Usersetting></Usersetting>
              </el-tab-pane>
              <el-tab-pane label="快递地址修改">
                <UserAddress></UserAddress>
              </el-tab-pane>
            </el-tabs>
          </el-tab-pane>
        </el-tabs>
      </el-main>
      </div>
      <mall-footer></mall-footer>
    </el-container>
  </div>
</template>

<script>

import MallFooter from "../components/MallFooter";
import LoginHeader from "../components/LoginHeader";
import ThingTittle from "../components/ThingTittle";
import UserData from "@/components/UserData";
import ItemOrder from "../components/ItemOrder";
import Usersetting from "@/components/Usersetting";
import CartCard from "../components/CartCard";
// import UserAddress from "@/components/UserAddress";

export default {
  name: "AboutMe",
  data() {
    return {
      tabPosition1: 'top',
      tabPosition2: 'left',
      selectedTag:"first",
    };
  },
  components: {
    //UserAddress,
    ItemOrder,
    UserData,
    ThingTittle,
    LoginHeader,
    MallFooter,
    Usersetting,
    CartCard,
  },
  mounted() {
    let sk=this.$route.query.selectedTag;
    if(sk==='1') {
      this.selectedTag='first'
    }
    if(sk==='2') {
      this.selectedTag='second'
    }
    if(sk==='3') {
      this.selectedTag='third'
    }
    if(sk==='4') {
      this.selectedTag='fourth'
    }
  }


}
</script>

<style scoped>
* {
  margin: 0;
  padding: 0
}
.main_content{
  margin: 0 auto;
  min-height: 750px;
  width: 100%;
}
.main_content:before{
  content: '';
  clear: both;
  display: block;
}
.main_box {
  margin: 10px auto;
  border: #7c7c7c solid 1px;
  height: 731px;
  width: 1380px;
}


</style>
