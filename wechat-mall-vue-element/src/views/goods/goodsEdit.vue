<template>
  <div class="app-container">
    <el-row>
      <el-col :span="3">
        <div style="height: 300px;">
          <el-steps direction="vertical" :active="activeStep">
            <el-step title="步骤 1" description="设置商品基本信息"></el-step>
            <el-step title="步骤 2" description="设置商品属性信息"></el-step>
          </el-steps>
          <el-button style="margin-top: 20px;" @click="changStep" v-if="activeStep===1">下一步</el-button>
          <el-button style="margin-top: 20px;" @click="changStep" v-if="activeStep===2">上一步</el-button>
        </div>
      </el-col>
      <el-col :span="21">
        <el-form :inline="true" :label-position="'top'" class="demo-form-inline">
          <el-tabs v-model="activeName">
            <el-tab-pane label="商品基本设置" name="first">
              <el-row>
                <el-col :span="6">
                  <el-form-item label="商品分类">
                    <el-cascader :props="props" placeholder="请选择分类" v-model="catArr" style="width: 300px"></el-cascader>
                  </el-form-item>
                </el-col>
                <el-col :span="10">
                  <el-form-item label="商品名字">
                    <el-input
                      v-model="goods.goodsName"
                      placeholder="请输入商品名字 *"
                      required
                      style="width: 600px"
                    ></el-input>
                  </el-form-item>
                </el-col>
              </el-row>
              <el-row>
                <el-col :span="6">
                  <el-form-item label="商品价格">
                    <el-input-number
                      v-model="goods.goodsPrice"
                      :precision="2"
                      :step="0.1"
                      :max="999999"
                      :min="0"
                    ></el-input-number>
                  </el-form-item>
                  <br/>
                  <el-form-item label="商品库存">
                    <el-input-number v-model="goods.goodsNumber" :step="1" :min="0"></el-input-number>
                  </el-form-item>
                  <br/>
                  <el-form-item label="商品重量(kg)">
                    <el-input-number
                      v-model="goods.goodsWeight"
                      :precision="2"
                      :step="0.1"
                      :max="999999"
                      :min="0"
                    ></el-input-number>
                  </el-form-item>
                </el-col>
                <el-col :span="5">
                  <el-form-item label="商品主图">
                    <el-upload
                      class="avatar-uploader"
                      :action="baseUpdateUrl"
                      :show-file-list="false"
                      :on-success="handleMainSuccess"
                      :before-upload="beforeMainUpload"
                      style="border: 1px black dotted; border-radius: 10px;"
                    >
                      <img v-if="goods.goodsBigLogo" :src="goods.goodsBigLogo" class="avatar">
                      <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="商品副图">
                    <el-upload
                      class="upload-demo"
                      :action="baseUpdateUrl"
                      :file-list="fileList"
                      :on-preview="handlePreview"
                      :before-remove="handleRemove"
                      :on-success="handleSecondSuccess"
                      list-type="picture-card"
                    >
                      <el-button size="small" type="primary">点击上传</el-button>
                      <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
                    </el-upload>
                  </el-form-item>
                </el-col>
              </el-row>
              <Editor v-model="goods.goodsIntroduce" style="width: 90%"/>
            </el-tab-pane>
            <el-tab-pane label="商品属性设置" name="second">
              <el-row>
                <el-button @click="showSpecKey = true">
                  选择商品需要的属性
                </el-button>
              </el-row>
              <el-row>
                <el-table
                  :data="tableSpecMessage"
                  style="width: 100%"
                  :height="400"
                >
                  <el-table-column
                    v-for="(item, index) in res_spec_kv"
                    :label="item.spec_name"
                    :prop="index.toString()"
                    sortable
                    width="130"
                    :key="item.spec_id"
                  >
                    <template
                      slot-scope="scope"
                    >
                      {{ scope.row[index]['name'] }}
                    </template>
                  </el-table-column>
                  <el-table-column
                    label="价格"
                    width="180"
                  >
                    <template slot-scope="scope">
                      <!--                  {{ scope.row[scope.row.length - 1]['price'] }}-->
                      <el-input-number
                        v-model="scope.row[scope.row.length-1]['price']"
                        size="small"
                        :min="0"
                        :max="9999"
                        label="描述文字"
                      ></el-input-number>
                    </template>
                  </el-table-column>
                  <el-table-column
                    label="库存"
                    width="180"
                  >
                    <template slot-scope="scope">
                      <!--                  {{ scope.row[scope.row.length - 1]['price'] }}-->
                      <el-input-number
                        v-model="scope.row[scope.row.length-1]['stock']"
                        size="small"
                        :min="0"
                        :max="9999"
                        label="描述文字"
                      ></el-input-number>
                    </template>
                  </el-table-column>
                </el-table>
              </el-row>
              <el-row>
                <el-button @click="showAddSpec = spec_key_val.length > 0">添加并设置商品属性值</el-button>
              </el-row>
              <el-form-item>
                <el-button type="primary" @click="onSubmit">提交</el-button>
              </el-form-item>
            </el-tab-pane>
          </el-tabs>
        </el-form>

      </el-col>
    </el-row>
    <el-dialog
      title="图片详情"
      :visible.sync="dialogVisible"
      width="40%"
    >
      <img width="100%" :src="dialogImageUrl"/>
    </el-dialog>
    <el-dialog
      title="商品属性选择"
      :visible.sync="showSpecKey"
      :before-close="selectedSpecKey"
    >
      <el-transfer
        filterable
        filter-placeholder="请输入属性名"
        :titles="['待选择属性', '已选择属性']"
        v-model="spec_key_val"
        :data="spec_key_data"
      >
      </el-transfer>
      <el-button style="margin-top: 20px;" @click="moreSpec">编辑商品属性</el-button>
    </el-dialog>
    <el-dialog
      title="添加并设置商品的属性"
      :visible.sync="showAddSpec"
      :before-close="setTableSpecMessage"
    >
      <el-form style="margin-left: 30px;">
        <el-row v-for="(item, index) in res_spec_kv" :key="index">
          <el-form-item :label="item.spec_name">
            <el-select style="width: 40%" v-model="resSelectedKV[index]" :key="index" multiple placeholder="请选择">
              <el-option
                v-for="itemArr in item.valueArr"
                :key="itemArr.spec_value_id"
                :label="itemArr.spec_value"
                :value="itemArr.spec_value_id"
              >
              </el-option>
            </el-select>
          </el-form-item>
        </el-row>
      </el-form>
    </el-dialog>
    <el-dialog
      title="更多属性值"
      :visible.sync="showMoreSpec"
    >
      <el-tree
        :data="specTree"
        node-key="id"
        accordion
        :default-expanded-keys="expSpecTree"
        :expand-on-click-node="false"
      >
        <span class="custom-tree-node" slot-scope="{ node, data }">
        <span>{{ node.label }}</span>
        <span style="margin-left: 30px;">
          <el-button
            v-if="data.children !== undefined"
            type="text"
            size="mini"
            @click="() => appendSpec(data)"
          >添加属性值</el-button>
          <el-button
            type="text"
            size="mini"
            @click="() => removeSpec(node, data)"
          >删除</el-button>
        </span>
      </span>
      </el-tree>
      <el-button style="margin-top: 20px;" @click="openAddSpecKey">
        添加属性
      </el-button>
    </el-dialog>
  </div>
</template>

<script>
import goodsApi from '@/api/goods'
import Editor from '@/components/Editor'

export default {
  components: { Editor },
  data() {
    return {
      isEdit: false,
      fileList: [],
      baseUpdateUrl: 'http://mall.php.test/upload/file',
      catArr: [],
      imageUrl: '',
      activeName: 'first',
      activeStep: 1, // 商品信息录入操作
      /**
       * 商品属性相关数据
       */
      spec_key_data: [], // 提供的可选择的商品属性
      spec_key_val: [], // 选出来的值
      res_spec_kv: [], // 通过请求获取选出来的值的kv
      showSpecKey: false,
      specBothData: [],
      showAddSpec: false,
      resSelectedKV: [],
      showMoreSpec: false,
      tableSpecMessage: [],
      specTree: [],
      filterSpecText: '',
      expSpecTree: [],
      /**
       * 商品数据
       */
      goods: {
        goodsBigLogo: '',
        goodsIntroduce: ''
      },
      dialogImageUrl: '',
      dialogVisible: false,
      props: {
        lazy: true,
        lazyLoad(node, resolve) {
          const { level } = node
          let value = node.value
          if (level === 0) {
            value = 0
          }
          goodsApi.getCategory(level + 1, value).then(res => {
            // console.log(node)
            let i = 0
            const nodes = Array.from({ length: res.data.length })
              .map(item => ({
                value: res.data[i].cat_id,
                label: res.data[i++].cat_name,
                leaf: level >= 2
              }))
            // 通过调用resolve将子节点数据返回，通知组件数据加载完成
            resolve(nodes)
          })
        }
      }
    }
  },
  created() {
    // 如果是跳转来的，则接受初始化参数
    if (this.$route.query.goods) {
      this.isEdit = true
      console.log(this.$route.query)
      this.goods.goodsId = this.$route.query.goods.goods_id
      this.goods.goodsName = this.$route.query.goods.goods_name
      this.goods.goodsIntroduce = this.$route.query.goods.goods_introduce
      this.goods.goodsPrice = this.$route.query.goods.goods_price
      this.goods.goodsNumber = this.$route.query.goods.goods_number
      this.goods.goodsWeight = this.$route.query.goods.goods_weight
      this.goods.goodsCatThreeId = this.$route.query.goods.goods_cat_three_id
      this.goods.goodsBigLogo = this.$route.query.goods.goods_big_logo
      this.goods.goodsPics = this.$route.query.goods.pics
      this.catArr = [
        this.$route.query.goods.goods_cat_one_id,
        this.$route.query.goods.goods_cat_two_id,
        this.$route.query.goods.goods_cat_three_id
      ]
      for (let i = 0; i < this.goods.goodsPics.length; i++) {
        const item = this.goods.goodsPics[i]
        this.fileList.push({ name: item.name, url: item.url, id: item.id })
      }
    }
    this.getAllSpecKey()
  },
  methods: {
    onSubmit() {
      this.goods.goodsCatThreeId = this.catArr[2]
      this.goods.pics = this.fileList
      this.goods.goodsInfo = this.tableSpecMessage
      goodsApi.saveOrUpdateGoods(this.goods)
        .then(res => {
          console.log(res)
          this.$router.push({
            path: '/goodsManager/goodsList'
          })
        })
        .catch(error => {
          console.log(error)
        })
    },
    changStep() {
      if (this.activeStep === 1 && this.activeName === 'first') {
        this.activeStep = 2
        this.activeName = 'second'
        console.log(this.activeStep, this.activeName)
      } else if (this.activeStep === 2 && this.activeName === 'second') {
        this.activeStep = 1
        this.activeName = 'first'
      }
    },
    handleMainSuccess(res, file) {
      this.goods.goodsBigLogo = res.data.url
      console.log(this.imageUrl)
    },
    beforeMainUpload(file) {
      const isLt2M = file.size / 1024 / 1024 < 10

      if (!isLt2M) {
        this.$message.error('上传图片大小不能超过 10MB!')
      }
      return isLt2M
    },
    handleRemove(file, fileList) {
      console.log(file)
      // 如果是编辑
      if (this.isEdit) {
        return this.$confirm('此操作将删除商品置信息, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          goodsApi.deletePic(file.id)
            .then(response => {
              console.log(response)
              this.$message({
                type: 'success',
                message: '删除成功!'
              })
            })
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '已取消删除'
          })
          this.reject(new Error('取消')).catch(err => {
            console.log(err)
          })
        })
        // TODO 从服务器删除list
      }
      this.removeByValue(this.fileList, 'url', file.url)
    },
    handlePreview(file) {
      this.dialogVisible = true
      console.log(file)
      this.dialogImageUrl = file.url
    },
    handleSecondSuccess(file) {
      this.fileList.push({ 'name': file.data.name, 'url': file.data.url, id: -1 })
    },
    // 根据属性值删除函数
    removeByValue(arr, attr, value) {
      let index = 0
      for (const i in arr) {
        if (arr[i][attr] === value) {
          index = i
          break
        }
      }
      arr.splice(index, 1)
    },
    getAllSpecKey() {
      goodsApi.getAllSpecKey().then(res => {
        this.spec_key_data = res.data
      }).catch(err => {
        console.log(err)
      })
    },
    getSpecKeyByIds(ids) {
      goodsApi.getSpecKeyByIds(ids).then(res => {
        this.res_spec_kv = res.data // 获取选出来的值的kv
        console.log(res.data)
      }).then(err => {
        console.log(err)
      })
    },
    selectedSpecKey() {
      this.getSpecKeyByIds(this.spec_key_val)
      this.tableSpecMessage = []
      this.resSelectedKV = []
      this.showSpecKey = false
    },
    moreSpec() {
      this.showMoreSpec = true
      this.getSpecTree()
    },
    getSpecTree() {
      goodsApi.getSpecTree()
        .then(res => {
          this.specTree = res.data
          console.log(this.specTree)
        })
        .catch(err => {
          console.log(err)
        })
    },
    appendSpec(data) {
      this.$prompt('请输入[' + data.label + ']要添加的属性值', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消'
      }).then(({ value }) => {
        goodsApi.addSpecValue(value, data.id)
          .then(res => {
            console.log(res)
            this.getAllSpecKey()
            this.getSpecTree()
            this.expSpecTree = []
            this.expSpecTree.push(data.id)
            this.$message({
              type: 'success',
              message: '添加成功: ' + value
            })
          })
          .catch(err => {
            console.log(err)
          })
      }).catch(() => {
      })
    },
    removeSpec(node, data) {
      console.log(node, data)
      if (data.type === 'key') {
        if (data.children.length !== 0) {
          console.log('还有子元素不能删除')
        } else {
          this.removeSpecKey(data.id)
        }
      } else if (data.type === 'value') {
        console.log(data.val_id)
        this.removeSpecValue(data.val_id)
      }
    },
    removeSpecKey(id) {
      goodsApi.removeSpecKey(id)
        .then(res => {
          console.log(res)
          this.getSpecTree()
          this.getAllSpecKey()
        })
        .catch(err => {
          console.log(err)
        })
    },
    removeSpecValue(id) {
      goodsApi.removeSpecValue(id)
        .then(res => {
          console.log(res)
          this.getSpecTree()
          this.getAllSpecKey()
          this.expSpecTree.push(res.data)
        })
        .catch(err => {
          console.log(err)
        })
    },
    openAddSpecKey() {
      this.$prompt('请输入属性名', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消'
      }).then(({ value }) => {
        goodsApi.addSpecKey(value)
          .then(res => {
            console.log(res)
            this.getAllSpecKey()
            this.getSpecTree()
            this.$message({
              type: 'success',
              message: '添加成功: ' + value
            })
          })
          .catch(err => {
            console.log(err)
          })
      }).catch(() => {
      })
    },
    setTableSpecMessage() {
      this.tableSpecMessage = this.countComb(this.resSelectedKV.slice(0)).slice(0)
      console.log(this.tableSpecMessage)
      if (!this.isArray(this.tableSpecMessage[0])) {
        const temp = this.tableSpecMessage.slice(0)
        for (let i = 0; i < temp.length; i++) {
          this.tableSpecMessage[i] = []
          this.tableSpecMessage[i].push(temp[i])
        }
      }
      for (let i = 0; i < this.tableSpecMessage.length; i++) {
        for (let j = 0; j < this.tableSpecMessage[i].length; j++) {
          // table message
          for (let a = 0; a < this.res_spec_kv.length; a++) {
            for (let b = 0; b < this.res_spec_kv[a]['valueArr'].length; b++) {
              const bool = (this.res_spec_kv[a]['valueArr'][b]['spec_value_id'] === this.tableSpecMessage[i][j])
              if (bool) {
                this.tableSpecMessage[i][j] = {
                  'id': this.tableSpecMessage[i][j],
                  'name': this.res_spec_kv[a]['valueArr'][b]['spec_value']
                }
              }
            }
          }
        }
        this.tableSpecMessage[i].push({ 'price': 0, 'stock': 0 })
      }
      this.showAddSpec = false
    },
    countComb(arr) {
      const len = arr.length
      // 当数组大于等于2个的时候
      if (len >= 2) {
        // 第一个数组的长度
        const len1 = arr[0].length
        // 第二个数组的长度
        const len2 = arr[1].length
        // 2个数组产生的组合数
        const lenBoth = len1 * len2
        //  申明一个新数组
        const items = new Array(lenBoth)
        // 申明新数组的索引
        let index = 0
        for (let i = 0; i < len1; i++) {
          for (let j = 0; j < len2; j++) {
            if (arr[0][i] instanceof Array) {
              items[index] = arr[0][i].concat(arr[1][j])
            } else {
              items[index] = [arr[0][i]].concat(arr[1][j])
            }
            index++
          }
        }
        const newArr = new Array(len - 1)
        for (let i = 2; i < arr.length; i++) {
          newArr[i - 1] = arr[i]
        }
        newArr[0] = items
        return this.countComb(newArr)
      } else {
        return arr[0]
      }
    },
    isArray(o) {
      return Object.prototype.toString.call(o) === '[object Array]'
    }
  },
  watch: {
    activeName(val) {
      this.activeStep = val === 'first' ? 1 : 2
    }
  }

}

</script>

<style scoped>
.avatar-uploader .el-upload {
  border: 1px dashed #413e3e;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}

.avatar-uploader .el-upload:hover {
  border-color: #031126;
}

.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 178px;
  height: 178px;
  line-height: 178px;
  text-align: center;
}

.avatar {
  width: 178px;
  height: 178px;
  display: block;
}
</style>
