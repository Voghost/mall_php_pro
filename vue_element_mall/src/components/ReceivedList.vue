<template>
  <div>
    <el-table
        :data="list_info"
        style="width: 100%"
        default-expand-all>
      <!--    :row-key="getRowKeys"-->
      <!--    :expand-row-keys="expands"-->
      <el-table-column type="expand"> //type="expand" 带下层数据的字段
        <template slot-scope="scope">
          <el-table class="demo-table-expand"
                    :data="scope.row.goods"
                    border
                    style="width: 100%">
            <el-table-column
                prop="goods.goods_image"
                label="商品照片"
                width="300"
            >
            </el-table-column>
            <el-table-column
                prop="goods_name"
                label="商品名字"
            >
            </el-table-column>
            <el-table-column
                prop="goods_price"
                label="商品单价"
                width="100"
            >
            </el-table-column>
            <el-table-column
                prop="goods_number"
                label="商品数量"
                width="100"
            >
            </el-table-column>
            <el-table-column
                label="商品总价"
                width="100"
            >
              <template slot-scope="scope">
                {{ scope.row.all_prices = scope.row.goods_number * scope.row.goods_price }}
              </template>
            </el-table-column>
            <el-table-column
                prop="goods_state"
                width="100"
                label="状态">
            </el-table-column>
            <el-table-column align="center" label="操作" width="120">
              <template>
                <el-button size="small" type="success" @click="handle=true">评价
                </el-button>
              </template>
            </el-table-column>
          </el-table>
        </template>
      </el-table-column>
      <el-table-column align="center"
                       label="订单编号"
                       prop="names">
      </el-table-column>
      <el-table-column align="center"
                       label="下单时间"
                       prop="date">
      </el-table-column>
    </el-table>
    <el-dialog title="评论" :visible.sync="handle" width="500px" center>
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
        </el-form-item>
      <span slot="footer">
      <el-button @click="handle = false">取 消</el-button>
      <el-button type="primary" @click="handle = false">确 定</el-button>
      </span>
      </el-form>
    </el-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        desc: "",
        star: null,
      },
      fileList: [],
      baseUpdateUrl: 'https://jsonplaceholder.typicode.com/posts/',
      textarea: '',
      handle: false,
      list_info: [{
        names: 'S201841413227',
        date: '2016-05-03',
        status: 1,
        all_prices: 2 * 123,
        goods: [{
          goods_image: '王小虎',
          goods_name: '你好',
          goods_price: 123,
          goods_number: 2,
          goods_prices: 0,
          goods_state: "待评价"
        }]
      },
        {
          names: 'S12456742194',
          date: '2016-05-03',
          status: 2,
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '20飞机杯一号',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 0,
            goods_state: "已完成"
          }]
        }],
    }
  },
  methods: {
    handleRemove(file, fileList) {
      console.log(file, fileList);
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    },
    handlePicSuccess(file) {
      console.log(file)
    },
    // fc(){
    //   if(this.status==1){
    //     ..
    //   }
    // }
  },
  props: ["status"]
}
</script>
