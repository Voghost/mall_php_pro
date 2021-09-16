<template>
  <div>
    <el-row justify="center" type="flex" style="width: 100%;">
      <el-col :span="10" style="">
        <el-carousel  style="float: right;width: 500px;height: 400px;margin-top: 30px;" indicator-position="outside">
          <el-carousel-item v-for="item in pics" :key="item">
              <el-image :src="item" :preview-src-list="pics"  :title="ClickTips"  style="width: 100%; height: 100%;" :fit="'cover'" >
              </el-image>
          </el-carousel-item>
        </el-carousel>
      </el-col>

      <el-col :span="12" style="font-size: 14px;margin-left: 30px;">
        <div style="margin-left: 30px">
          <div style="height: 40px;margin-top: 30px;font-size: 20px;">
            小米米家电动滑板车Pro 45公里续航成人学生迷你便携锂电池可折叠双轮休闲踏板平衡车体感车
<!--            {{goods.goods_name}}-->
          </div>
          <div style="height: 100px;margin-left: 20px;margin-top: 20px">
            价格：<span style="font-size: 30px;color: #00A0E9">￥{{goods.goods_price}}</span>
            <br>
            优惠：<span style="font-size: 30px;color: #00A0E9">没有优惠</span>
          </div>
          <div style="height: 40px;line-height: 40px;margin-left: 20px;">
            <span>评论：1000+</span>
            <span style="margin-left: 40px">收藏：1000+</span>
          </div>
          <div style="height: 60px;line-height: 60px;">
            购买数量：<el-input-number v-model="num" @change="handleChange" :min="1" :max="10" label="购买数量"></el-input-number>
          </div>

          <div style="height: 80px;min-width: 400px;">
            <el-button type="primary"  @click="ShoppingCar"  plain icon="el-icon-shopping-cart-full" style="margin: 20px;width: 160px">购物车</el-button>
            <el-button type="primary"  @click="GoodsBuy" style="margin: 20px;width: 160px;">购买</el-button>
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

      <el-tabs  v-model="tabsName" style="margin-left: 35px;margin-top: 20px;font-size: 20px">
        <el-tab-pane label="产品评论" name="first" >
          <el-form  label-width="100px" :model="form">
            <el-form-item label="产品评分:">
              <el-rate v-model="form.star"  show-text></el-rate>
            </el-form-item>
            <el-form-item label="评价内容:">
              <el-input type="textarea" :rows="4" v-model="form.desc"></el-input>
            </el-form-item>
            <el-form-item label="上传照片:">
              先不搞
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="onSubmit">提交</el-button>
              <el-button>取消</el-button>
            </el-form-item>
          </el-form>
        </el-tab-pane>

        <el-tab-pane label="产品详情" name="second">
          <el-descriptions title="商品信息" :column="3">
            <el-descriptions-item label="商品名字：">{{goods.goods_name}}</el-descriptions-item>
            <el-descriptions-item label="商品编号：">{{goods.goods_id}}</el-descriptions-item>
            <el-descriptions-item label="商品重量：">{{goods.goods_weight}}</el-descriptions-item>
            <el-descriptions-item label="商品描述："> <div  v-html="goods.goods_introduce">{{goods.goods_introduce}}</div></el-descriptions-item>
          </el-descriptions>
          <div v-for="item in pics_introduce" :key="item">
            <el-image :src="item" style="width: 100%; height: 100%;" :fit="'cover'" >
            </el-image>
          </div>
        </el-tab-pane>

        <el-tab-pane label="销售记录" name="third" style="font-size: 14px">
          <div style="height: 60px;line-height: 60px;font-size: 16px;">
            好评度:<span style="font-size: 30px;color: red;margin-left: 10px">94%</span>
          </div>
          <el-tabs v-model="evaluationName" type="card" style="margin-top: 20px">
            <el-tab-pane label="全部评价" name="first">
              <div style="margin-left: 20px;box-shadow: 0 2px 4px rgba(0, 0, 0, .12), 0 0 6px rgba(0, 0, 0, .04)" >
                <el-row >
                  <el-col :span="5" >小菜菜子</el-col>
                  <el-col :span="7" >
                    <el-rate v-model="StarValue"
                             disabled
                             show-score
                             :value="-1"
                             text-color="#ff9900"
                             score-template="{value}">
                    </el-rate>
                  </el-col>
                </el-row>
                <el-row >
                  <el-col :span="10" :offset="5" >
                    <div style="width: 100%;">手机很快收到了，Apple iPhone 12 的屏幕看起来太喜欢了。后感非常好，这应该是女生都喜欢的手机了吧，尤其是拍照效果真的太好了，双摄像头，后摄像头1200万像素，夜拍也很清晰，比起11，升级了很多。</div>

                      <el-row>
                        <el-col :span="3" v-for="item in pics" :key="item">
                          <el-image :src="item" style="width: 50px;height: 50px;" :preview-src-list="pics"  :title="ClickTips"   :fit="'contain'" >
                          </el-image>
                        </el-col>
                      </el-row>
                  </el-col>
                </el-row>
              </div>
              <div style="margin-left: 20px;box-shadow: 0 2px 4px rgba(0, 0, 0, .12), 0 0 6px rgba(0, 0, 0, .04)" >
                <el-row >
                  <el-col :span="5" >小菜菜子</el-col>
                  <el-col :span="7" >
                    <el-rate v-model="StarValue"
                             disabled
                             show-score
                             :value="-1"
                             text-color="#ff9900"
                             score-template="{value}">
                    </el-rate>
                  </el-col>
                </el-row>
                <el-row >
                  <el-col :span="10" :offset="5" >
                    <div style="width: 100%;">手机很快收到了，Apple iPhone 12 的屏幕看起来太喜欢了。后感非常好，这应该是女生都喜欢的手机了吧，尤其是拍照效果真的太好了，双摄像头，后摄像头1200万像素，夜拍也很清晰，比起11，升级了很多。</div>

                    <el-row>
                      <el-col :span="3" v-for="item in pics" :key="item">
                        <el-image :src="item" style="width: 50px;height: 50px;" :preview-src-list="pics"  :title="ClickTips"   :fit="'contain'" >
                        </el-image>
                      </el-col>
                    </el-row>
                  </el-col>
                </el-row>
              </div>
              <div style="margin-left: 20px;box-shadow: 0 2px 4px rgba(0, 0, 0, .12), 0 0 6px rgba(0, 0, 0, .04)" >
                <el-row >
                  <el-col :span="5" >小菜菜子</el-col>
                  <el-col :span="7" >
                    <el-rate v-model="StarValue"
                             disabled
                             :value="-1"
                             show-score
                             text-color="#ff9900"
                             score-template="{value}">
                    </el-rate>
                  </el-col>
                </el-row>
                <el-row >
                  <el-col :span="10" :offset="5" >
                    <div style="width: 100%;">手机很快收到了，Apple iPhone 12 的屏幕看起来太喜欢了。后感非常好，这应该是女生都喜欢的手机了吧，尤其是拍照效果真的太好了，双摄像头，后摄像头1200万像素，夜拍也很清晰，比起11，升级了很多。</div>

                    <el-row>
                      <el-col :span="3" v-for="item in pics" :key="item">
                        <el-image :src="item" style="width: 50px;height: 50px;" :preview-src-list="pics"  :title="ClickTips"   :fit="'contain'" >
                        </el-image>
                      </el-col>
                    </el-row>
                  </el-col>
                </el-row>
              </div>
            </el-tab-pane>
            <el-tab-pane label="好评" name="second">好评</el-tab-pane>
            <el-tab-pane label="差评" name="third">差评</el-tab-pane>
          </el-tabs>
        </el-tab-pane>
      </el-tabs>
    </div>

</template>

<script>
export default {
  name: "GoodsDetails",
  data() {
    return {
      pics: [
        "https://27140273.s61i.faiusr.com/4/AD0IscH4DBAEGAAg2eyjhQYonPbJ4gQw7gU47gU.png",
        "https://27140273.s61i.faiusr.com/2/AD0IscH4DBACGAAgzKOVhQYo_caoUTD2BDiwAw!700x700.jpg"

      ],
      pics_introduce : [
          "https://img13.360buyimg.com/imgzone/jfs/t1/155542/29/11266/164521/5fe2fc01Ebb26c06a/7112e9fa18ce76d5.jpg",
          "https://img30.360buyimg.com/imgzone/jfs/t1/141324/23/19776/169193/5fe2fc02E79fa003d/6de0d4ed030f3834.jpg",
          "https://img13.360buyimg.com/imgzone/jfs/t1/155753/13/1655/175594/5fe2fc03Ebfcbd048/65734f5257a99ec9.jpg"
      ],
      num: 1,
      tabsName : 'first',//标签页默认显示
      evaluationName : 'first',
      StarValue: 3,
      form : {
        desc:"",
        star:null,
      },
      ClickTips : "点击查看大图",
      goods :{}
    }
  },
  methods: {
    handleChange(value){
      console.log(value);
    },
    getGoodsInfo(id) {
      this.$api.goods.detail(id).then(res=>{
        this.goods = res.data.message;
        // console.log(res.data.message);
        console.log(this.goods);
      }).catch(err=>{
        console.log(err);
      })
    },
    //评论提交
    onSubmit(){
      console.log('submit')
    },
    //购物车
    ShoppingCar(){
      console.log('shopping')
    },
    //购买
    GoodsBuy(){
      console.log('buy')
    }
  },
  mounted() {
    this.getGoodsInfo(130);
  }

}
</script>

<style scoped>

</style>