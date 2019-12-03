<template>
    <div class="productEditor-container">
        <el-form ref="postForm" :model="postForm" :rules="rules" class="form-container">
          <sticky :z-index="10" :class-name="'sub-navbar '+postForm.status">
          This is the form.
            <!-- CommentDropdown v-model="postForm.comment_disabled" />
            <PlatformDropdown v-model="postForm.platforms" />
            <SourceUrlDropdown v-model="postForm.source_uri" / -->
            <el-button v-loading="loading" style="margin-left: 10px;" type="success" @click="submitForm">
              Publish
            </el-button>
            <el-button v-loading="loading" type="warning" @click="draftForm">
              Draft
          </el-button>
          </sticky>
          <div class="productEditor-main-container">
            <el-form-item style="margin-bottom: 40px;" prop="title">
              <MDinput v-model="postForm.title" :maxlength="100" name="name" required>
                Title
              </MDinput>
            </el-form-item>

            <el-form-item prop="content" style="margin-bottom: 30px;">
              <Tinymce ref="editor" v-model="postForm.content" :height="400" />
            </el-form-item>
          </div>
        </el-form>

    </div>
</template>

<script>
import MDinput from '@/components/MDinput'
import Sticky from '@/components/Sticky' // 粘性header组件
import Tinymce from '@/components/Tinymce'

const defaultProduct = {
  status: 'draft',
  sku: '',
  title: '', // 文章题目
  content: '', // 文章内容
  suppliers: [], // 文章外链
  protos: [], // 文章图片
  display_time: undefined, // 前台展示时间
  id: undefined,
}
/**
import Upload from '@/components/Upload/SingleImage3'
import { validURL } from '@/utils/validate'
import { fetchArticle } from '@/api/article'
import { searchUser } from '@/api/remote-search'
//import Warning from './Warning'


export default {
    name: 'ProductEditor',
    components: { Tinymce, MDinput, Upload, Sticky, Warning },
}
*/
export default {
    name: 'ProductEditor',
    components : { Sticky, MDinput, Tinymce },
    props: {
        isEdit: {
            type: Boolean,
            default: false
        }
    },
    data() {
        const validateRequire = (rule, value, callback) => {
              if (value === '') {
                this.$message({
                  message: rule.field + ' is required',
                  type: 'error'
                })
                callback(new Error(rule.field + ' is required'))
              } else {
                callback()
              }
        }
        return {
            postForm: Object.assign({}, defaultProduct),
            loading: false,
            rules: {
                title: [{validator: validateRequire }],
                content: [{validator: validateRequire }]
            },
            tempRoute: {}
        }
    },
    created() {
        if (this.isEdit) {
            const id = this.$route.params && this.$route.params.id
            this.fetchData(id)
        }
        this.tempRoute = Object.assign({}, this.$route)
    },
    methods: {
        fetchData(id) {
            /*
            fetchProduct(id).then(response => {

            })*/
        },
        submitForm() {
            console.log(this.postForm)
        }
    }
}
</script>

<style lang="scss" scoped>
@import "~@/styles/mixin.scss";

.productEditor-container {
  position: relative;

  .productEditor-main-container {
    padding: 40px 45px 20px 50px;

    .postInfo-container {
      position: relative;
      @include clearfix;
      margin-bottom: 10px;

      .postInfo-container-item {
        float: left;
      }
    }
  }

  .word-counter {
    width: 40px;
    position: absolute;
    right: 10px;
    top: 0px;
  }
}

.article-textarea /deep/ {
  textarea {
    padding-right: 40px;
    resize: none;
    border: none;
    border-radius: 0px;
    border-bottom: 1px solid #bfcbd9;
  }
}
</style>
