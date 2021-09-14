<template>
  <el-container>
    <el-menu
        :default-active="activeIndex2"
        class="el-menu-demo"
        mode="horizontal"
        @select="handleSelect"
        background-color="#545c64"
        text-color="#fff"
        active-text-color="#ffd04b">
      <el-menu-item index="1">处理中心</el-menu-item>
      <el-submenu index="2">
        <template slot="title">我的工作台</template>
        <Category/>
      </el-submenu>
      <el-menu-item index="3" disabled>消息中心</el-menu-item>
      <el-menu-item index="4"><a href="https://www.ele.me" target="_blank">订单管理</a></el-menu-item>
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

<style scoped>
.border {
  border: 1px red solid;
}

</style>
