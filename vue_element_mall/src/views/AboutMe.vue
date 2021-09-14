<template>
  <div>
    <el-container>
      <el-container>
        <el-header class="">
          <LoginHeader></LoginHeader>
          <ThingTittle style="box-shadow: rgba(0,0,0,0.3) 0 0 3px"></ThingTittle>
        </el-header>
      </el-container>
      <el-container style="width: 1200px;height: auto;margin:0 auto">
        <el-main class="main_box">
          <el-tabs :tab-position="tabPosition" style="height: auto;width: auto;margin: 10px">
            <el-tab-pane label="账号资料">
              <UserData></UserData>
            </el-tab-pane>
            <el-tab-pane label="购物车">

            </el-tab-pane>
            <el-tab-pane label="全部订单">
              <ItemOrder></ItemOrder>
            </el-tab-pane>
          </el-tabs>
        </el-main>
      </el-container>
      <el-footer class="">
        <mall-footer></mall-footer>
      </el-footer>
    </el-container>
  </div>
</template>

<script>

import MallFooter from "../components/MallFooter";
import LoginHeader from "../components/LoginHeader";
import ThingTittle from "../components/ThingTittle";
import UserData from "@/components/UserData";
import ItemOrder from "../components/ItemOrder";

export default {
  name: "AboutMe",
  data(){
    return {
      tabPosition: 'top'
    };
  },
  components: {
    ItemOrder,
    UserData,
    ThingTittle,
    LoginHeader,
    MallFooter,
  }


}
</script>

<style scoped>
*{margin: 0;padding: 0}

.main_box{
  margin:60px  0 ;
  border: #7c7c7c solid 1px;
  float: left;
  height: auto;
  width: auto;


}





</style>
