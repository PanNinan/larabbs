# LaraBBS - Laravel 论坛系统

<p align="center">
  <img src="https://laravel.com/assets/img/components/logo-laravel.svg" alt="Laravel Logo" width="150">
</p>

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/Laravel-5.7-orange.svg" alt="Laravel Version"></a>
  <a href="#"><img src="https://img.shields.io/badge/PHP-7.1+-blue.svg" alt="PHP Version"></a>
  <a href="#"><img src="https://img.shields.io/badge/Vue-2.5-green.svg" alt="Vue Version"></a>
  <a href="#"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="License"></a>
</p>

## 项目简介

LaraBBS 是一个基于 Laravel 5.7 开发的现代化论坛系统，支持 Web 端和 RESTful API，具备完整的用户认证、话题管理、回复互动、通知系统等核心功能。同时集成微信小程序、微信公众号、短信服务、极光推送等多平台能力。

## 功能特性

### 核心功能
- **用户系统**：注册、登录、邮箱验证、密码重置、个人资料管理
- **话题系统**：发布、编辑、删除话题，支持 Markdown 编辑器
- **分类系统**：话题按分类组织，支持分类筛选
- **回复系统**：对话题进行评论和回复
- **通知系统**：话题被回复时自动通知作者
- **权限管理**：基于角色的访问控制（RBAC）

### API 功能
- **RESTful API**：完整的 API 接口，支持 JWT 认证
- **第三方登录**：微信 OAuth、微信小程序登录
- **短信服务**：支持短信验证码注册/登录
- **图片上传**：头像、话题图片上传
- **频率限制**：API 接口访问频率控制

### 管理功能
- **后台管理**：基于 Laravel Administrator 的内容管理
- **队列任务**：异步处理通知、图片处理等任务
- **Horizon 监控**：队列任务实时监控

## 技术栈

### 后端
| 技术/组件 | 版本 | 说明 |
|-----------|------|------|
| Laravel Framework | 5.7.* | PHP Web 框架 |
| PHP | ^7.1.3 | PHP 版本要求 |
| Dingo/API | ^2.0.0-alpha2 | API 开发工具包 |
| JWT Auth | 1.0.0-rc.3 | API 身份认证 |
| Redis | ~1.1 | 缓存、队列存储 |
| Laravel Horizon | ~1.3 | 队列监控面板 |
| Spatie Permission | ~2.29 | 角色权限管理 |
| Intervention Image | ^2.4 | 图片处理 |
| GuzzleHTTP | ~6.3 | HTTP 客户端 |
| Easy SMS | ^1.1 | 短信服务（云片） |
| Laravel WeChat | ~4.0 | 微信 SDK |
| JPush | ^3.6 | 极光推送 |

### 前端
| 技术/组件 | 版本 | 说明 |
|-----------|------|------|
| Vue.js | ^2.5.17 | 前端框架 |
| Bootstrap | ^4.0.0 | UI 框架 |
| jQuery | ^3.5 | DOM 操作 |
| Axios | ^0.18 | HTTP 请求 |
| Laravel Mix | ^4.0.7 | 前端构建工具 |
| Sass | ^1.15.2 | CSS 预处理器 |
| FontAwesome | ^5.6.3 | 图标库 |

## 项目结构

```
larabbs/
├── app/
│   ├── Console/              # Artisan 命令
│   │   └── Commands/         # 自定义命令（计算活跃用户、同步登录时间等）
│   ├── Exceptions/           # 异常处理
│   ├── Handlers/             # 处理器（图片上传、Slug 翻译）
│   ├── Http/
│   │   ├── Controllers/      # 控制器
│   │   │   ├── Api/          # API 控制器
│   │   │   └── Auth/         # 认证控制器
│   │   ├── Middleware/       # 中间件
│   │   ├── Requests/         # 表单请求验证
│   │   │   └── Api/          # API 请求验证
│   │   └── Kernel.php        # HTTP 内核
│   ├── Jobs/                 # 队列任务（Slug 翻译）
│   ├── Listeners/            # 事件监听器
│   ├── Models/               # 数据模型
│   │   ├── User.php          # 用户模型（JWT、角色、通知）
│   │   ├── Topic.php         # 话题模型
│   │   ├── Reply.php         # 回复模型
│   │   ├── Category.php      # 分类模型
│   │   ├── Link.php          # 友情链接模型
│   │   ├── Image.php         # 图片模型
│   │   └── Traits/           # 模型 Trait（活跃用户、最后活跃时间）
│   ├── Notifications/        # 通知类（话题被回复通知）
│   ├── Observers/            # 模型观察者
│   ├── Policies/             # 授权策略
│   ├── Providers/            # 服务提供者
│   ├── Transformers/         # API 数据转换器（Fractal）
│   └── helpers.php           # 全局辅助函数
├── config/                   # 配置文件
├── database/
│   ├── migrations/           # 数据库迁移（20+ 个迁移文件）
│   └── seeds/                # 数据种子
├── resources/
│   ├── views/                # Blade 模板
│   ├── js/                   # JavaScript 源码
│   └── sass/                 # Sass 样式
├── routes/
│   ├── web.php               # Web 路由
│   └── api.php               # API 路由（Dingo/API）
├── public/                   # 入口文件、静态资源
├── storage/                  # 存储文件
└── tests/                    # 测试代码
```

## 数据库结构

### 主要数据表

| 表名 | 说明 | 关联关系 |
|------|------|----------|
| `users` | 用户表 | hasMany: topics, replies, notifications |
| `topics` | 话题表 | belongsTo: user, category; hasMany: replies |
| `replies` | 回复表 | belongsTo: user, topic |
| `categories` | 分类表 | hasMany: topics |
| `notifications` | 通知表 | belongsTo: user |
| `links` | 友情链接表 | - |
| `images` | 图片表 | morphTo: user |
| `roles` / `permissions` | 角色权限表 | Spatie Permission |

## 安装部署

### 环境要求
- PHP >= 7.1.3
- MySQL >= 5.7
- Redis
- Composer
- Node.js & NPM

### 安装步骤

1. **克隆项目**
```bash
git clone https://github.com/yourusername/larabbs.git
cd larabbs
```

2. **安装 PHP 依赖**
```bash
composer install
```

3. **安装前端依赖**
```bash
npm install
npm run dev
```

4. **配置环境变量**
```bash
cp .env.example .env
php artisan key:generate
```

编辑 `.env` 文件，配置数据库、Redis、邮件、微信等参数：
```env
APP_NAME=LaraBBS
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=larabbs
DB_USERNAME=root
DB_PASSWORD=your_password

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# 微信配置
WECHAT_OFFICIAL_ACCOUNT_APPID=your-app-id
WECHAT_OFFICIAL_ACCOUNT_SECRET=your-app-secret
WECHAT_MINI_PROGRAM_APPID=your-mini-app-id
WECHAT_MINI_PROGRAM_SECRET=your-mini-secret

# 短信配置
EASY_SMS_API_KEY=your-api-key
```

5. **执行数据库迁移**
```bash
php artisan migrate
```

6. **填充初始数据**
```bash
php artisan db:seed
```

7. **创建存储目录软链接**
```bash
php artisan storage:link
```

8. **启动队列监听（可选，用于异步任务）**
```bash
php artisan horizon
```

### 开发环境
```bash
# 启动开发服务器
php artisan serve

# 监听前端资源变化
npm run watch
```

## API 文档

### API 基础信息
- **Base URL**: `/api`
- **版本**: v1
- **认证方式**: JWT Token
- **响应格式**: JSON

### 主要接口

#### 公开接口（无需 Token）
| 方法 | 路径 | 说明 |
|------|------|------|
| POST | `/api/verificationCodes` | 发送短信验证码 |
| POST | `/api/captchas` | 获取图片验证码 |
| POST | `/api/users` | 用户注册 |
| POST | `/api/authorizations` | 用户登录 |
| POST | `/api/socials/{type}/authorizations` | 第三方登录 |
| POST | `/api/weapp/authorizations` | 小程序登录 |
| GET | `/api/categories` | 获取分类列表 |
| GET | `/api/topics` | 获取话题列表 |
| GET | `/api/topics/{topic}` | 话题详情 |
| GET | `/api/users/{user}/topics` | 用户话题列表 |

#### 认证接口（需要 Token）
| 方法 | 路径 | 说明 |
|------|------|------|
| GET | `/api/user` | 当前用户信息 |
| PATCH | `/api/user` | 更新用户信息 |
| POST | `/api/images` | 上传图片 |
| POST | `/api/topics` | 发布话题 |
| PATCH | `/api/topics/{topic}` | 更新话题 |
| DELETE | `/api/topics/{topic}` | 删除话题 |
| POST | `/api/topics/{topic}/replies` | 发布回复 |
| GET | `/api/user/notifications` | 通知列表 |
| PATCH | `/api/user/read/notifications` | 标记已读 |

### 认证方式
在请求头中添加：
```
Authorization: Bearer {your-jwt-token}
```

## 常用命令

```bash
# 执行迁移
php artisan migrate

# 回滚迁移
php artisan migrate:rollback

# 重置并重新运行迁移
php artisan migrate:fresh --seed

# 运行队列任务
php artisan queue:work

# 启动 Horizon（队列监控）
php artisan horizon

# 生成 JWT 密钥
php artisan jwt:secret

# 计算活跃用户
php artisan larabbs:calculate-active-user

# 同步用户最后活跃时间
php artisan larabbs:sync-user-actived-at

# 生成 API Token（测试用）
php artisan larabbs:generate-token
```

## 安全特性

- **CSRF 保护**：所有表单提交都经过 CSRF 验证
- **XSS 过滤**：使用 HTML Purifier 过滤用户输入
- **SQL 注入防护**：使用 Eloquent ORM 参数绑定
- **接口频率限制**：API 接口访问频率控制
- **JWT Token 认证**：API 使用 JWT 进行身份验证
- **角色权限控制**：基于 Spatie Permission 的 RBAC

## 性能优化

- **Redis 缓存**：缓存活跃用户、话题列表等数据
- **数据库索引**：关键字段添加索引优化查询
- **队列任务**：异步处理通知、图片处理等耗时操作
- **Horizon 监控**：实时监控队列任务执行情况
- **图片压缩**：使用 Intervention Image 处理上传图片

## 贡献指南

欢迎提交 Issue 和 Pull Request。

1. Fork 本仓库
2. 创建你的特性分支 (`git checkout -b feature/AmazingFeature`)
3. 提交你的修改 (`git commit -m 'Add some AmazingFeature'`)
4. 推送到分支 (`git push origin feature/AmazingFeature`)
5. 打开一个 Pull Request

## 许可证

本项目基于 [MIT](https://opensource.org/licenses/MIT) 许可证开源。

## 致谢

- [Laravel](https://laravel.com/) - 优秀的 PHP 框架
- [Laravel China 社区](https://laravel-china.org/) - 教程和文档支持
- [Summer](https://github.com/summerblue) - 教程作者

## 架构设计说明

### 路由设计

#### Web 路由 (`routes/web.php`)
- 首页路由指向话题列表
- 自定义认证路由（登录、注册、密码重置、邮箱验证）
- RESTful 资源路由：users、topics、categories、replies、notifications
- 图片上传专用路由

#### API 路由 (`routes/api.php`)
使用 Dingo/API 包管理，版本为 v1：
- **命名空间**: `App\Http\Controllers\Api`
- **中间件**: `serializer:array`, `bindings`, `ChangeLocale`
- **频率限制**: 普通接口 60 次/分钟，登录相关 10 次/分钟

### 控制器设计

#### Web 控制器
| 控制器 | 主要方法 | 功能 |
|--------|----------|------|
| `TopicsController` | index, show, create, store, edit, update, destroy | 话题 CRUD、图片上传 |
| `UsersController` | show, edit, update | 用户资料展示与编辑 |
| `RepliesController` | store, destroy | 回复发布与删除 |
| `CategoriesController` | show | 分类话题列表 |
| `NotificationsController` | index | 通知列表展示 |

#### API 控制器
| 控制器 | 主要方法 | 功能 |
|--------|----------|------|
| `UsersController` | store, update, me, activedIndex | 用户注册、更新、当前用户、活跃用户 |
| `TopicsController` | index, show, store, update, destroy, userIndex | 话题 API 操作 |
| `RepliesController` | index, store, destroy, userIndex | 回复 API 操作 |
| `AuthorizationsController` | store, update, destroy, socialStore, weappStore | JWT 认证、第三方登录 |
| `VerificationCodesController` | store | 短信验证码发送 |
| `ImagesController` | store | 图片上传处理 |

### 模型设计

#### 模型关系图
```
┌─────────────┐       ┌─────────────┐       ┌─────────────┐
│    users    │       │   topics    │       │  categories │
├─────────────┤       ├─────────────┤       ├─────────────┤
│ id          │──┐    │ id          │   ┌───│ id          │
│ name        │  │    │ title       │   │   │ name        │
│ email       │  │    │ body        │   │   │ description │
│ avatar      │  │    │ user_id     │───┘   └─────────────┘
│ ...         │  └───>│ category_id │───┘
└─────────────┘       │ ...         │
       │              └─────────────┘
       │                     │
       │              ┌──────┘
       │              ▼
       │       ┌─────────────┐
       │       │   replies   │
       │       ├─────────────┤
       │       │ id          │
       └──────>│ user_id     │
               │ topic_id    │
               │ content     │
               └─────────────┘
```

#### 模型特性

**User 模型**
- 实现 `JWTSubject` 接口（API 认证）
- 实现 `MustVerifyEmail` 接口（邮箱验证）
- 使用 `HasRoles` Trait（权限管理）
- 使用自定义 Trait：`ActiveUserHelper`, `LastActivedAtHelper`
- 关联关系：`topics()`, `replies()`
- 访问器/修改器：`setPasswordAttribute`, `setAvatarAttribute`

**Topic 模型**
- 作用域方法：`scopeWithOrder`, `scopeRecent`, `scopeRecentReplied`
- 关联关系：`category()`, `user()`, `replies()`
- 生成 SEO 友好的 URL：`link()` 方法

### 请求验证

使用 Laravel 的 Form Request 进行请求验证：

| 请求类 | 用途 |
|--------|------|
| `TopicRequest` | 话题创建/编辑验证 |
| `ReplyRequest` | 回复发布验证 |
| `UserRequest` | 用户信息更新验证 |
| `Api\UserRequest` | API 用户注册/更新验证 |
| `Api\TopicRequest` | API 话题创建/更新验证 |
| `Api\AuthorizationRequest` | API 登录验证 |
| `Api\VerificationCodeRequest` | 短信验证码请求验证 |

### 数据转换器 (Transformers)

使用 Fractal 进行 API 数据转换：

| 转换器 | 包含关系 |
|--------|----------|
| `UserTransformer` | roles |
| `TopicTransformer` | user, category |
| `ReplyTransformer` | user, topic |
| `CategoryTransformer` | - |
| `NotificationTransformer` | - |

### 中间件

| 中间件 | 用途 |
|--------|------|
| `Authenticate` | 用户认证 |
| `EnsureEmailIsVerified` | 邮箱验证检查 |
| `RecordLastActivedTime` | 记录用户最后活跃时间 |
| `ChangeLocale` | API 语言切换 |
| `api.throttle` | API 频率限制 |

### 队列任务

| 任务类 | 用途 |
|--------|------|
| `TranslateSlug` | 异步翻译话题 Slug |

### 事件监听

| 监听器 | 触发事件 | 用途 |
|--------|----------|------|
| `EmailVerified` | Verified | 邮箱验证后处理 |
| `PushNotification` | TopicReplied | 推送回复通知 |

### 模型观察者

| 观察者 | 观察模型 | 用途 |
|--------|----------|------|
| `UserObserver` | User | 用户创建后初始化 |
| `TopicObserver` | Topic | 话题创建/保存后生成 Slug |
| `ReplyObserver` | Reply | 回复创建后更新话题数据、发送通知 |
| `LinkObserver` | Link | 缓存清理 |

### 授权策略

| 策略 | 资源 | 权限控制 |
|------|------|----------|
| `TopicPolicy` | Topic | update, destroy |
| `ReplyPolicy` | Reply | destroy |
| `UserPolicy` | User | update |

---

<p align="center">Made with ❤️ by PanNinan</p>
