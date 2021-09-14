<template>
  <div style="width: 250px; box-shadow: rgba(0,0,0,0.3) 0 0 5px"
       background-color="#f0f0f0">
    <el-submenu v-for="level1 in category" :index="level1.cat_id.toString()" :key="level1.cat_id">
      <template slot="title">
        {{ level1.cat_name }}
<!--        <i class="el-icon-arrow-right" style="margin-right: 30px; margin-top: 20px; float: right"></i>-->
      </template>
      <el-menu-item-group>
        <span slot="title">{{ level1.cat_name }}</span>
        <el-submenu v-for="level2 in level1.children" :index="level2.cat_id.toString()" :key="level2.cat_id">
          <span slot="title">{{ level2.cat_name }}</span>
          <el-menu-item v-for="level3 in level2.children" :index="level3.cat_id.toString()" :key="level3.cat_id">
            {{ level3.cat_name }}
          </el-menu-item>
        </el-submenu>
      </el-menu-item-group>
    </el-submenu>
  </div>
</template>

<script>
export default {
  name: "Category",
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

<style >



</style>
