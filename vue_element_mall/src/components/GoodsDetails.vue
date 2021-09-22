<template>
  <div style="width: 70%; margin: 0 auto; min-width: 800px">
    <!--购物信息-->
    <el-row justify="center" type="flex" style="width: 100%;">
      <!--左侧图片-->
      <el-col :span="8">
        <el-carousel height="420px" style=" width: 100%;margin-top: 30px;" indicator-position="outside">
          <el-carousel-item v-for="(item,index) in goods.pic" :key="index">
            <el-image :src="item" :preview-src-list="goods.pic" :title="ClickTips" style="width: 100%; height: 100%;"
                      :fit="'fill'">
            </el-image>
          </el-carousel-item>
        </el-carousel>
      </el-col>
      <!--右侧信息-->
      <el-col :span="12" style="font-size: 14px;margin-left: 60px;margin-top: 30px">
        <div>
          <div style="height: 100%;font-size: 20px;">
            {{ goods.goods_name }}
          </div>
          <div style="margin-left: 20px">
            <div style="margin-top: 20px;">
              价格：<span style="font-size: 30px;color: #00A0E9">￥{{ goods.goods_price }}</span>
            </div>
            <!--调用规格-->
            <div>
              <GoodsAttribute :gid="this.goods_id" :g_info="getInfo"></GoodsAttribute>
            </div>
            <!--            <div style="height: 40px;line-height: 40px;">-->
            <!--              <span>评论：1000+</span>-->
            <!--              <span style="margin-left: 40px">收藏：1000+</span>-->
            <!--            </div>-->
            <div class="GoodsCount" style="margin-top: 10px;font-size: 0.8em;">以剩库存: {{goodsInfo.goods_stock}}</div>
          </div>

          <div style="margin-top: 20px;">
            购买数量：
            <el-input-number v-model="num" @change="handleChange" :min="1" :max="10" label="购买数量"></el-input-number>
          </div>

          <div style="height: 80px;min-width: 400px;">
            <el-button type="primary" @click="ShoppingCar" plain icon="el-icon-shopping-cart-full"
                       style="margin: 20px;width: 160px">购物车
            </el-button>
            <el-button type="primary" @click="GoodsBuy" style="margin: 20px;width: 160px;">购买</el-button>
          </div>

          <div style="height: 40px;line-height: 40px;">
            产品保证<i class="el-icon-circle-check" style="margin-left: 20px"></i>
            正品保证<i class="el-icon-circle-check" style="margin-left: 10px"></i>
            快速发货
          </div>
        </div>
      </el-col>
    </el-row>

    <div style="height: 40px;font-size: 14px;line-height: 40px;margin-left: 35px">
      <el-link :underline="false" icon="el-icon-star-off" style="margin-right: 5px">收藏</el-link>
      <el-link :underline="false" icon="el-icon-share" style="margin:0px 5px 0px 20px;">分享</el-link>
      <el-link :underline="false" icon="el-icon-chat-dot-round" style="margin:0px 5px 0px 20px;">客服</el-link>
    </div>
    <!-- 下方功能页-->
    <el-tabs v-model="tabsName" style="margin-left: 35px;margin-top: 20px;font-size: 20px">

      <el-tab-pane label="产品评论" name="first">
        <el-form label-width="100px" :model="form" ref="loginFormRef">
          <el-form-item label="产品评分:">
            <el-rate v-model="form.star" show-text></el-rate>
          </el-form-item>
          <el-form-item label="评价内容:">
            <el-input type="textarea" :rows="3" v-model="form.desc" :maxlength="150" placeholder="请输入内容"
                      show-word-limit></el-input>
          </el-form-item>
          <el-form-item label="上传照片:">
            <el-upload :action="baseUpdateUrl"
                       list-type="picture-card"
                       :file-list="fileList"
                       :on-success="handlePicSuccess"
                       :on-remove="handleRemove"
                       :on-preview="handlePictureCardPreview">
              <el-button size="small" type="primary">点击上传</el-button>
              <div slot="tip" class="el-upload__tip">只能上传3个jpg/png文件，且不超过10MB</div>
            </el-upload>
            <el-dialog :visible.sync="dialogVisible">
              <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>

          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="onSubmit">提交</el-button>
            <el-button>取消</el-button>
          </el-form-item>
        </el-form>
      </el-tab-pane>

      <el-tab-pane label="产品详情" name="second">
        <el-descriptions title="商品信息" :column="1" border>
          <el-descriptions-item label="商品名字：">{{ goods.goods_name }}</el-descriptions-item>
          <el-descriptions-item label="商品编号：">{{ goods.goods_id }}</el-descriptions-item>
          <el-descriptions-item label="商品重量：">{{ goods.goods_weight }}</el-descriptions-item>
        </el-descriptions>
        <div v-html="goods.goods_introduce">{{ goods.goods_introduce }}</div>

      </el-tab-pane>

      <el-tab-pane label="销售记录" name="third" style="font-size: 14px">
        <div style="height: 60px;line-height: 60px;font-size: 16px;">
          好评度:<span style="font-size: 30px;color: red;margin-left: 10px">{{this.Praise}}%</span>
        </div>
        <el-tabs v-model="evaluationName" type="card" style="margin-top: 20px">
          <el-tab-pane label="全部评价" name="first">
            <div style="margin-left: 20px;box-shadow: 0 2px 4px rgba(0, 0, 0, .12), 0 0 6px rgba(0, 0, 0, .04)"
                 v-for="(item,index) in comment" :key="index">
              <el-row style="margin-top: 10px">
                <el-col :span="5">{{ item.username }}</el-col>
                <el-col :span="7">
                  <el-rate v-model="item.star"
                           disabled
                           show-score
                           :value="-1"
                           text-color="#ff9900"
                           score-template="{value}">
                  </el-rate>
                </el-col>
              </el-row>
              <el-row>
                <el-col :span="10" :offset="5">
                  <div style="width: 100%;">{{ item.content }}</div>
                  <el-row>
                    <el-col :span="3" v-for="(pic,index) in item.pics" :key="index">
                      <el-image :src="pic" style="width: 50px;height: 50px;" :title="ClickTips" :preview-src-list="item.pics" :fit="'contain'">
                      </el-image>
                    </el-col>
                  </el-row>
                </el-col>
              </el-row>
            </div>
            <el-pagination
                background
                @current-change="changePage"
                :page-size="size"
                layout="prev, pager, next"
                :total="totalNum"
                style="text-align: center"
            >
            </el-pagination>
          </el-tab-pane>
          <el-tab-pane label="好评" name="second">
            <div style="margin-left: 20px;box-shadow: 0 2px 4px rgba(0, 0, 0, .12), 0 0 6px rgba(0, 0, 0, .04)"
                 v-for="(item,index) in comment" :key="index">
              <el-row style="margin-top: 10px">
                <!--                  <el-col :span="5" >{{item.user_id}}</el-col>-->
                <el-col :span="5" v-if="item.star>3">{{ item.username }}</el-col>
                <el-col :span="7" v-if="item.star>3">
                  <el-rate v-model="item.star"
                           disabled
                           show-score
                           :value="-1"
                           text-color="#ff9900"
                           score-template="{value}">
                  </el-rate>
                </el-col>
              </el-row>
              <el-row>
                <el-col :span="10" :offset="5">
                  <div style="width: 100%;" v-if="item.star>3">{{ item.content }}</div>
                  <el-row>
                    <el-col :span="3" v-for="(pic,index) in item.pics" :key="index">
                      <el-image :src="pic" style="width: 50px;height: 50px;" :title="ClickTips" :fit="'contain'" v-if="item.star>3">
                      </el-image>
                    </el-col>
                  </el-row>
                </el-col>
              </el-row>
            </div>
          </el-tab-pane>
          <el-tab-pane label="差评" name="third">
            <div style="margin-left: 20px;box-shadow: 0 2px 4px rgba(0, 0, 0, .12), 0 0 6px rgba(0, 0, 0, .04)"
                 v-for="(item,index) in comment" :key="index">
              <el-row style="margin-top: 10px">
                <!--                  <el-col :span="5" >{{item.user_id}}</el-col>-->
                <el-col :span="5" v-if="item.star<3">{{ item.username }}</el-col>
                <el-col :span="7" v-if="item.star<3">
                  <el-rate v-model="item.star"
                           disabled
                           show-score
                           :value="-1"
                           text-color="#ff9900"
                           score-template="{value}">
                  </el-rate>
                </el-col>
              </el-row>
              <el-row>
                <el-col :span="10" :offset="5">
                  <div style="width: 100%;" v-if="item.star<3">{{ item.content }}</div>
                  <el-row>
                    <el-col :span="3" v-for="(pic,index) in item.pics" :key="index">
                      <el-image :src="pic" style="width: 50px;height: 50px;" :title="ClickTips" :fit="'contain'" v-if="item.star<3">
                      </el-image>
                    </el-col>
                  </el-row>
                </el-col>
              </el-row>
            </div>
          </el-tab-pane>
        </el-tabs>
      </el-tab-pane>
    </el-tabs>
  </div>

</template>

<script>
import GoodsAttribute from "@/components/GoodsAttribute";

export default {
  name: "GoodsDetails",
  components: {GoodsAttribute},
  data() {
    return {
      goods: {},
      goodsInfo: {},
      comment: {},
      num: 1,
      starTotal : 0,
      Praise : 0,
      style: 1,
      fileList: [],
      tabsName: 'first',//标签页默认显示
      evaluationName: 'first',  //评论页默认显示
      // baseUpdateUrl: 'http://mall.php.test/upload/file',
      baseUpdateUrl: 'https://jsonplaceholder.typicode.com/posts/',

      form: {
        desc: "",
        star: null,
      },
      ClickTips: "点击查看大图",
      username: "傻逼",

      size: 3,
      currentPage: 1,
      row_index: 0,
      totalNum: 0,

      dialogImageUrl: '',
      dialogVisible: false,
    }
  },

  methods: {
    //照片上传
    handleRemove(file, fileList) {
      console.log(file, fileList);
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    },
    handleChange(value) {
      console.log(value);
    },
    getGoodsInfo(id) {
      this.$api.goods.detail(id).then(res => {
        this.goods = res.data.message;
        console.log(this.goods);
        this.pageSearch();
      }).catch(err => {
        console.log(err);
      })
    },
    pageSearch(page = 1) {
      this.currentPage = page
      console.log("1",this.goods)
      this.$api.user.pageSearch(this.currentPage, this.size,this.goods.goods_id)
          .then(res => {
            this.comment = res.data.message.content;
            this.totalNum = res.data.message.total;
            this.row_index = res.data.message.content.length;
            if(this.comment.length%this.row_index){
              this.row_index++;
            }
            console.log(res.data)
          })
          .catch(err => {
            console.log(err)
          })
    },
    changePage(page) {
      this.pageSearch(page)
      document.documentElement.scrollTop = 680;
    },
    handlePicSuccess(file) {
      console.log(file)
    },
    //评论提交
    onSubmit() {
      console.log('submit')
    },
    //购物车
    ShoppingCar() {
      if(Object.keys(this.goodsInfo).length>0){
        let item = {info_id : this.goodsInfo.info_id,number : this.num};
        this.$api.goods.shoppingCar(item).then(res=>{
          console.log(2,res.data);
          this.$message({
            message: '恭喜你，加入购物车成功',
            type: 'success'
          });
        })
      }else {
        this.$message({
          message: '警告哦，请选择完所有规格哦，宝贝',
          type: 'warning'
        });
      }
    },
    //购买
    GoodsBuy() {
      console.log('buy')
    },
    getInfo(info) {
      this.goodsInfo = info;
    }
  },
  props: [
    'goods_id',
  ],
  mounted() {
    console.log(this.goods_id);
    this.getGoodsInfo(this.goods_id);

  },
  watch: {
    goodsInfo: {
      deep: true,
      handler(newVal, oldVal) {
        console.log(oldVal)
        this.goods.goods_price = newVal.goods_price;
      }
    }
  }
}
</script>

<style scoped>

</style>
