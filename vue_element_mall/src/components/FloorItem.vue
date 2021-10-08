<template>
  <!--    楼层  -->
  <div style="width: 100%;">
    <div style="width: 1100px; height: 60px; margin: 0 auto" class="">
      <i style="line-height: 60px; font-size: 44px; margin-left: 20px;">{{ num }} F</i>
      <span style="margin-left: 30px; font-size: 20px">{{ title }}</span>
      <div style="width: 100%; height: 2px; background-color: black; margin: 0 auto"></div>
    </div>
    <el-image
        style="
          {
            height: 300px;
            width: 1100px;
            margin: 10px auto;
            display: block;
            box-shadow: rgba(0,0,0,0.2) 0 0 10px;
          }"
        :src="this.src"
        @click="searchGoods()"
        :fit="'cover'">
    </el-image>
  </div>
</template>

<script>
export default {
  name: "FloorItem",
  props: ['src', "num", "title", "floorKeyword"],
  data() {
    return {
      kw: ''
    }
  },
  mounted() {
    this.kw = this.floorKeyword;
    console.log("kw", this.floorKeyword)
  },
  methods: {
    searchGoods() {
      this.$router.push({
        path: `/allgoods?name=${this.kw}`
      })
    }
  }

}
</script>

<style scoped>

</style>
