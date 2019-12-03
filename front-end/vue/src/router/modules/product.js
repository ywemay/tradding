
import Layout from '@/layout'

const productRouter = {
    path: '/product',
    component: Layout,
    redirect: '/product/list',
    name: 'Prodct',
    meta: {
        title: 'Product',
        icon: 'product'
    },
    children:[
        {
            path: 'create',
            component: () => import('@/views/product/create'),
            name: 'CreateProduct',
            meta: {title: 'Create Product'}
        },
        {
            path: 'list',
            component: () => import('@/views/product/list'),
            name: 'ProductListing',
            meta: {title: 'Products Listing'}
        },
        {
            path: 'view/:id(\\d+)',
            component: () => import('@/views/product/view'),
            name: 'ViewProduct',
            meta: { title: 'View Product', activeMenu: 'product/list' },
            hidden: true
        },
        {
            path: 'edit/:id(\\d+)',
            component: () => import('@/views/product/edit'),
            name: 'EditProduct',
            meta: { title: 'Edit Product', activeMenu: 'product/list' },
            hidden: true
        }
    ]
}

export default productRouter
