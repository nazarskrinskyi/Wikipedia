<x-app-layout>
    <div class="max-w-3xl w-full mx-auto p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg mt-10">
        <form action="{{ isset($article) ? route('articles.update', $article) : route('articles.store') }}"
            method="POST">
            @csrf
            @if (isset($article))
                @method('PUT')
            @endif

            <!-- Title -->
            <div class="mb-6">
                <label for="title"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $article->title ?? '') }}"
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:ring focus:ring-indigo-500 p-3 @error('title') border-red-500 @enderror"
                    required>
                @error('title')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div class="mb-6">
                <label for="slug"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Slug</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $article->slug ?? '') }}"
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:ring focus:ring-indigo-500 p-3 @error('slug') border-red-500 @enderror"
                    required>
                @error('slug')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label for="editor"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
                <input type="hidden" name="content" id="content"
                    value="{{ old('content', $article->content ?? '') }}" />
                <div id="editor"
                    class="ck-content border rounded-lg p-4 min-h-[200px] border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500 shadow-sm">
                    {!! old('content', $article->content ?? '') !!}
                </div>
                @error('content')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-6">
                <label for="category_id"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                <select id="category_id" name="category_id"
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:ring focus:ring-indigo-500 p-3 @error('category_id') border-red-500 @enderror">
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $article->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hidden user_id -->
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Short
                    Description</label>
                <textarea id="description" name="description"
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:ring focus:ring-indigo-500 p-3 @error('description') border-red-500 @enderror"
                    rows="3">{{ old('description', $article->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="text-right">
                <button type="submit"
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ isset($article) ? 'Update' : 'Create' }} Article
                </button>
            </div>
        </form>
    </div>

    <!-- CKEditor 5 -->
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.2.1/ckeditor5.css" crossorigin>
    <script src="https://cdn.ckeditor.com/ckeditor5/44.2.1/ckeditor5.umd.js" crossorigin></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const nameInput = document.getElementById("title");
            const slugInput = document.getElementById("slug");

            function transliterate(text) {
                const map = {
                    а: 'a',
                    б: 'b',
                    в: 'v',
                    г: 'g',
                    д: 'd',
                    е: 'e',
                    ё: 'e',
                    ж: 'zh',
                    з: 'z',
                    и: 'i',
                    й: 'y',
                    к: 'k',
                    л: 'l',
                    м: 'm',
                    н: 'n',
                    о: 'o',
                    п: 'p',
                    р: 'r',
                    с: 's',
                    т: 't',
                    у: 'u',
                    ф: 'f',
                    х: 'h',
                    ц: 'ts',
                    ч: 'ch',
                    ш: 'sh',
                    щ: 'shch',
                    ъ: '',
                    ы: 'y',
                    ь: '',
                    э: 'e',
                    ю: 'yu',
                    я: 'ya',
                    є: 'ye',
                    і: 'i',
                    ї: 'yi',
                    ґ: 'g'
                };

                return text.toLowerCase().split('').map(char =>
                    map[char] || char
                ).join('');
            }

            function generateSlug(text) {
                return transliterate(text)
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            }

            nameInput.addEventListener("input", function() {
                slugInput.value = generateSlug(nameInput.value);
            });
        });




        const {
            ClassicEditor,
            Autoformat,
            AutoImage,
            Autosave,
            BlockQuote,
            Bold,
            CloudServices,
            Emoji,
            Essentials,
            Bookmark,
            ImageBlock,
            ImageCaption,
            ImageInline,
            ImageInsert,
            ImageInsertViaUrl,
            ImageResize,
            ImageStyle,
            ImageTextAlternative,
            ImageToolbar,
            ImageUpload,
            Indent,
            IndentBlock,
            Italic,
            Link,
            LinkImage,
            Mention,
            Paragraph,
            SimpleUploadAdapter,
            Table,
            TableCaption,
            TableCellProperties,
            TableColumnResize,
            TableProperties,
            TableToolbar,
            TextTransformation,
            Underline,
            Alignment,
            FontSize,
            FontColor,
            FontBackgroundColor,
            Highlight,
            Subscript,
            Strikethrough,
            Superscript,
            MediaEmbed,
            CodeBlock,
        } = window.CKEDITOR;

        const LICENSE_KEY =
            "eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NzE3MTgzOTksImp0aSI6ImQ2ZTg0NGUxLWY1ZTMtNDcxNC04NGUwLTQwZWMyZjkyNmQ1YiIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiXSwiZmVhdHVyZXMiOlsiRFJVUCJdLCJ2YyI6IjU0ZDAwNzM3In0.YytQnwN1J25Vs6dGqO3-A89N7lgG6XNTwS3UU3seia74mu3bikIHKGGB5AlH2tKak0uzc_McnZm-9wzdCkh_Lw";

        const editorConfig = {
            toolbar: {
                items: [
                    "undo",
                    "redo",
                    "codeBlock",
                    "bookmark",
                    "|",
                    "bold",
                    "italic",
                    "underline",
                    "strikethrough",
                    "subscript",
                    "superscript",
                    "|",
                    "fontSize",
                    "fontColor",
                    "fontBackgroundColor",
                    "highlight",
                    "|",
                    "alignment",
                    "link",
                    "insertImage",
                    "insertImageViaUrl",
                    "insertTable",
                    "blockQuote",
                    "|",
                    "outdent",
                    "indent",
                    "|",
                    "mediaEmbed",
                ],
                shouldNotGroupWhenFull: false,
            },
            plugins: [
                Autoformat,
                AutoImage,
                Autosave,
                BlockQuote,
                Bold,
                CloudServices,
                Emoji,
                Essentials,
                Bookmark,
                ImageBlock,
                ImageCaption,
                ImageInline,
                ImageInsert,
                ImageInsertViaUrl,
                ImageResize,
                ImageStyle,
                ImageTextAlternative,
                ImageToolbar,
                ImageUpload,
                Indent,
                IndentBlock,
                Italic,
                Link,
                LinkImage,
                Mention,
                Paragraph,
                SimpleUploadAdapter,
                Table,
                TableCaption,
                TableCellProperties,
                TableColumnResize,
                TableProperties,
                TableToolbar,
                TextTransformation,
                Underline,
                Alignment,
                FontSize,
                FontColor,
                FontBackgroundColor,
                Highlight,
                Strikethrough,
                Subscript,
                Superscript,
                MediaEmbed,
                CodeBlock,
            ],
            language: "uk",
            licenseKey: LICENSE_KEY,
            link: {
                addTargetToExternalLinks: true,
                defaultProtocol: "https://",
                decorators: {
                    toggleDownloadable: {
                        mode: "manual",
                        label: "Downloadable",
                        attributes: {
                            download: "file",
                        },
                    },
                },
            },
            mention: {
                feeds: [{
                    marker: "@",
                    feed: [],
                }, ],
            },
            image: {
                toolbar: [
                    "toggleImageCaption",
                    "imageTextAlternative",
                    "|",
                    "imageStyle:inline",
                    "imageStyle:wrapText",
                    "imageStyle:breakText",
                    "|",
                    "resizeImage",
                ],
            },
            table: {
                contentToolbar: [
                    "tableColumn",
                    "tableRow",
                    "mergeTableCells",
                    "tableProperties",
                    "tableCellProperties",
                ],
            },
            fontSize: {
                options: [
                    "10px",
                    "12px",
                    "14px",
                    "16px",
                    "18px",
                    "20px",
                    "24px",
                    "28px",
                    "32px",
                    "36px",
                    "40px",
                ],
                supportAllValues: true,
            },
            simpleUpload: {
                uploadUrl: "/ckeditor/upload",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            },
        };

        ClassicEditor.create(document.querySelector("#editor"), editorConfig)
            .then((editor) => {
                editor.model.document.on("change:data", () => {
                    document.querySelector("#content").value = editor.getData();
                });
            })
            .catch((error) => console.error("CKEditor initialization error:", error));
    </script>
</x-app-layout>
