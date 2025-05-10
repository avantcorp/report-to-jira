# Report to Jira

#### Install via composer
```shell
composer require avantcorp/report-to-jira
```

#### Configure Tailwind
- tailwind.config.js (v3)
```javascript
export default {
    content: [
        ...
        "./vendor/avantcorp/report-to-jira/resources/views/*.blade.php"
    ],
};
```
- resources/css/app.css (v4)
```css
@import "tailwindcss";
@source "../../vendor/avantcorp/report-to-jira/resources/views/*.blade.php";
...
```

#### Add to blade layout file
```bladehtml
    ...
    @include('report-to-jira::form')
    </body>
</html>
```
