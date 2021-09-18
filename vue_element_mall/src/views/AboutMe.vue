<template>
  <div>
    <LoginHeader></LoginHeader>
    <ThingTittle style="box-shadow: rgba(0,0,0,0.3) 0 0 3px"></ThingTittle>
    <el-container style="width: 1380px;min-height:700px;margin:0 auto">
      <el-main class="main_box">
        <el-tabs :tab-position="tabPosition1" style="margin: 10px;">
          <el-tab-pane label="账号资料">
            <UserData></UserData>
          </el-tab-pane>
          <el-tab-pane label="购物车">
            <CartCard></CartCard>
          </el-tab-pane>
          <el-tab-pane label="全部订单">
            <ItemOrder></ItemOrder>
          </el-tab-pane>
          <el-tab-pane label="账户信息修改">
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
    </el-container>
    <mall-footer></mall-footer>
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
import UserAddress from "@/components/UserAddress";

export default {
  name: "AboutMe",
  data() {
    return {
      tabPosition1: 'top',
      tabPosition2: 'left'
    };
  },
  components: {
    UserAddress,
    ItemOrder,
    UserData,
    ThingTittle,
    LoginHeader,
    MallFooter,
    Usersetting,
    CartCard,
  }


}
</script>

<style scoped>
* {
  margin: 0;
  padding: 0
}

.main_box {
  margin: 20px 0;
  border: #7c7c7c solid 1px;
  float: left;
  height: auto;
  width: auto;
}


</style>
