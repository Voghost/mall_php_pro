<template>
  <el-container>
    <el-menu
        class="el-menu-demo"
        mode="horizontal"
        text-color="#fff"
        background-color="#000"
        active-text-color="#ffd04b">
      <el-submenu index="1">
        <template slot="title">商品分类</template>
        <Category/>
      </el-submenu>
      <el-menu-item index="2" id="1"><a href="#" target="_parent">商城首页</a></el-menu-item>
      <el-menu-item index="3" id="1"><a href="http://localhost:8081/allgoods" target="_parent">全部商品</a></el-menu-item>
    </el-menu>
  </el-container>
</template>

<script>
import Category from "@/components/Category";
export default {
  name: "404",
  components: {Category},
  data() {
    return {
      category: {},
    }
  },
  mounted() {
    this.$api.main_page.allCategory()
        .then(res => {
          this.category = res.data.message
        })
        .catch(err => {
          console.log(err)
        })
  }
}
</script>

<style>
.border {
  border: 1px red solid;

}
.el-menu{
  width: 100%;
}
.el-submenu__title:hover,.el-submenu__title:focus{
  background-color: #00BFFF!important;
}
.el-menu--horizontal > .el-submenu.is-active .el-submenu__title{
  color: white !important;
  border-bottom-color: transparent !important;
}


.el-menu-item:hover{
  background-color: #00BFFF!important;
}
/*.el-menu-item.is-active {*/
/*  color: #ffff00 !important;*/
/*  background: #000000 !important;*/
/*  border-bottom-color: transparent !important;*/
/*}*/
a{
  text-decoration: none;
  color: white;
}

</style>
