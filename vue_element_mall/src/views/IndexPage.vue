<template>
  <div>
    <el-backtop target=".app" :visibility-height="400"></el-backtop>
    <el-container direction="vertical">
      <MallHeader/>
      <!--功能区-->
      <SearchHeader style="box-shadow: rgba(0,0,0,0.3) 0 0 7px"/>
      <NavColumns></NavColumns>
      <el-main class="" style="width: 100%; height: 600px; margin-top: 0; padding: 0">
        <el-carousel height="500px" indicator-position="outside" style="width: 100%">
          <el-carousel-item v-for="item in pics" :key="item.goods_id">
            <a :href="'/goodsDetail?goods_id='+item.goods_id">
              <el-image :src="item.image_src" style="width: 100%; height: 100%" :fit="'cover'">
              </el-image>
            </a>
          </el-carousel-item>
        </el-carousel>
      </el-main>

      <el-main class="">
        <FloorItem v-for="(item, index) in floors"
                   :key="item.floor_title.name"
                   :src="item.floor_title.image_src"
                   :num="index+1"
                   :floor-keyword="item.floor_title.keyword"
                   :title="item.floor_title.name"
        />
      </el-main>

      <MallFooter></MallFooter>
    </el-container>
  </div>
</template>

<script>
import MallHeader from "@/components/MallHeader";
import SearchHeader from "@/components/SearchHeader";
// import FloorItem from "@/components/FloorItem";
import MallFooter from "@/components/MallFooter";
import FloorItem from "@/components/FloorItem";
import NavColumns from "../components/NavColumns";

export default {
  name: 'IndexPage',
  data() {
    return {
      pics: [],
      categories: {},
      floors: {},
      floorNum: 1,
    }
  },
  inject: ['reload'],
  components: {
    // FloorItem,
    MallHeader,
    SearchHeader,
    NavColumns,
    FloorItem,
    MallFooter
  },
  methods: {
    getAllFloor() {
      this.$api.main_page.floor()
          .then(res => {
            this.floors = res.data.message
            console.log(this.floors)
          })
    },
    getSwiperPics() {
      this.$api.main_page.getPics()
          .then(res => {
            this.pics = res.data.message;
          })
          .catch(err => {
            console.log(err)
          })
    },

  },
  mounted() {
    this.getAllFloor();
    this.getSwiperPics();
    this.$api.goods.pageSearch(1, 10, {"goods_name": "飞机"})
        .then(res => {
          console.log(res.data)
        })
        .catch(err => {
          console.log(err)
        })
  }
}
</script>
<style>

body {
  min-width: 900px;
}

* {
  margin: 0;
  padding: 0;
}

.main {
  height: 500px;
  width: 800px;
  /*border: 2px solid black;*/
}

.border {
  border: 2px solid red;
}


.title {
  width: 120px;
  margin: 10px auto;
  font-size: 20px;
  float: right;
}

.content {
  clear: both;
  list-style: none;
  width: 120px;
  margin: 10px auto;
  font-size: 14px;
  float: right;
}

.content > li {
  margin-top: 4px;
}

</style>
