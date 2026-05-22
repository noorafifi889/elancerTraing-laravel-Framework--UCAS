@include('dashboard.categories.create', [
    'category' => $category, // تمرير كائن الكاتيجوري المراد تعديله
    'action'   => route('categories.update', $category->id), // توجيهه لدالة الـ update في الـ CategoryController
    'method'   => 'PUT' // تحديد الطريقة كـ PUT للتعديل
])