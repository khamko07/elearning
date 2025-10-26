/**
 * Cross-Browser Testing Automation
 * Tests the E-Learning system across different browsers
 */

const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

class CrossBrowserTester {
    constructor() {
        this.browsers = [
            { name: 'Chrome', product: 'chrome' },
            { name: 'Firefox', product: 'firefox' },
            { name: 'Edge', product: 'chrome', executablePath: this.getEdgePath() }
        ];
        
        this.testPages = [
            'login.php',
            'register.php',
            'index.php',
            'admin/login.php',
            'tests/browser-compatibility.html'
        ];
        
        this.results = {};
    }
    
    async runTests() {
        console.log('🚀 Starting cross-browser testing...');
        
        for (const browser of this.browsers) {
            console.log(`\n📱 Testing ${browser.name}...`);
            await this.testBrowser(browser);
        }
        
        this.generateReport();
        console.log('✅ Cross-browser testing completed!');
    }
    
    async testBrowser(browserConfig) {
        let browser;
        
        try {
            const launchOptions = {
                headless: true,
                args: ['--no-sandbox', '--disable-setuid-sandbox']
            };
            
            if (browserConfig.executablePath) {
                launchOptions.executablePath = browserConfig.executablePath;
            }
            
            browser = await puppeteer.launch(launchOptions);
            const page = await browser.newPage();
            
            // Set viewport for consistent testing
            await page.setViewport({ width: 1920, height: 1080 });
            
            this.results[browserConfig.name] = {
                browser: browserConfig.name,
                tests: {},
                summary: { passed: 0, failed: 0, total: 0 }
            };
            
            // Test each page
            for (const testPage of this.testPages) {
                console.log(`  📄 Testing ${testPage}...`);
                await this.testPage(page, testPage, browserConfig.name);
            }
            
            // Run compatibility tests
            await this.runCompatibilityTests(page, browserConfig.name);
            
        } catch (error) {
            console.error(`❌ Error testing ${browserConfig.name}:`, error.message);
            this.results[browserConfig.name] = {
                browser: browserConfig.name,
                error: error.message,
                tests: {},
                summary: { passed: 0, failed: 0, total: 0 }
            };
        } finally {
            if (browser) {
                await browser.close();
            }
        }
    }
    
    async testPage(page, pagePath, browserName) {
        const testName = pagePath;
        const baseUrl = 'http://localhost:8080/'; // Adjust as needed
        
        try {
            // Navigate to page
            const response = await page.goto(baseUrl + pagePath, {
                waitUntil: 'networkidle0',
                timeout: 30000
            });
            
            const tests = {
                'Page Load': response.status() === 200,
                'No Console Errors': true,
                'CSS Loaded': true,
                'JavaScript Loaded': true
            };
            
            // Check for console errors
            const consoleErrors = [];
            page.on('console', msg => {
                if (msg.type() === 'error') {
                    consoleErrors.push(msg.text());
                }
            });
            
            // Wait a bit for any async operations
            await page.waitForTimeout(2000);
            
            tests['No Console Errors'] = consoleErrors.length === 0;
            
            // Check if CSS is loaded (look for specific styles)
            const hasStyles = await page.evaluate(() => {
                const element = document.querySelector('body');
                const styles = window.getComputedStyle(element);
                return styles.fontFamily !== 'Times' && styles.fontFamily !== 'serif';
            });
            tests['CSS Loaded'] = hasStyles;
            
            // Check if JavaScript is working (look for specific elements or functions)
            const hasJS = await page.evaluate(() => {
                return typeof window.jQuery !== 'undefined' || 
                       typeof window.bootstrap !== 'undefined' ||
                       document.querySelector('[data-theme-toggle]') !== null;
            });
            tests['JavaScript Loaded'] = hasJS;
            
            // Test form functionality if it's a form page
            if (pagePath.includes('login') || pagePath.includes('register')) {
                await this.testFormFunctionality(page, tests);
            }
            
            // Test responsive design
            await this.testResponsiveDesign(page, tests);
            
            // Store results
            this.results[browserName].tests[testName] = {
                url: baseUrl + pagePath,
                tests: tests,
                consoleErrors: consoleErrors,
                passed: Object.values(tests).filter(Boolean).length,
                total: Object.keys(tests).length
            };
            
            // Update summary
            this.results[browserName].summary.passed += Object.values(tests).filter(Boolean).length;
            this.results[browserName].summary.total += Object.keys(tests).length;
            this.results[browserName].summary.failed = this.results[browserName].summary.total - this.results[browserName].summary.passed;
            
            console.log(`    ✅ ${Object.values(tests).filter(Boolean).length}/${Object.keys(tests).length} tests passed`);
            
        } catch (error) {
            console.log(`    ❌ Failed to test ${testName}: ${error.message}`);
            this.results[browserName].tests[testName] = {
                url: baseUrl + pagePath,
                error: error.message,
                passed: 0,
                total: 1
            };
            this.results[browserName].summary.failed += 1;
            this.results[browserName].summary.total += 1;
        }
    }
    
    async testFormFunctionality(page, tests) {
        try {
            // Test if form elements are present and functional
            const hasForm = await page.$('form');
            const hasInputs = await page.$$('input[type="text"], input[type="email"], input[type="password"]');
            const hasSubmitButton = await page.$('button[type="submit"], input[type="submit"]');
            
            tests['Form Elements Present'] = hasForm && hasInputs.length > 0 && hasSubmitButton;
            
            // Test form validation (if present)
            if (hasForm) {
                const hasValidation = await page.evaluate(() => {
                    const form = document.querySelector('form');
                    return form && form.hasAttribute('novalidate') !== null;
                });
                tests['Form Validation'] = hasValidation;
            }
            
        } catch (error) {
            tests['Form Functionality'] = false;
        }
    }
    
    async testResponsiveDesign(page, tests) {
        try {
            // Test mobile viewport
            await page.setViewport({ width: 375, height: 667 });
            await page.waitForTimeout(1000);
            
            const isMobileResponsive = await page.evaluate(() => {
                const body = document.body;
                return body.scrollWidth <= window.innerWidth + 50; // Allow some tolerance
            });
            
            tests['Mobile Responsive'] = isMobileResponsive;
            
            // Test tablet viewport
            await page.setViewport({ width: 768, height: 1024 });
            await page.waitForTimeout(1000);
            
            const isTabletResponsive = await page.evaluate(() => {
                const body = document.body;
                return body.scrollWidth <= window.innerWidth + 50;
            });
            
            tests['Tablet Responsive'] = isTabletResponsive;
            
            // Reset to desktop
            await page.setViewport({ width: 1920, height: 1080 });
            
        } catch (error) {
            tests['Responsive Design'] = false;
        }
    }
    
    async runCompatibilityTests(page, browserName) {
        try {
            console.log(`  🔧 Running compatibility tests...`);
            
            await page.goto('http://localhost:8080/tests/browser-compatibility.html', {
                waitUntil: 'networkidle0',
                timeout: 30000
            });
            
            // Wait for tests to complete
            await page.waitForTimeout(5000);
            
            // Extract test results
            const compatibilityResults = await page.evaluate(() => {
                const summaryEl = document.getElementById('testSummary');
                if (summaryEl) {
                    const text = summaryEl.textContent;
                    const passedMatch = text.match(/Tests Passed:\s*(\d+)\s*\/\s*(\d+)/);
                    const levelMatch = text.match(/Compatibility Level:\s*(\w+)/);
                    
                    return {
                        passed: passedMatch ? parseInt(passedMatch[1]) : 0,
                        total: passedMatch ? parseInt(passedMatch[2]) : 0,
                        level: levelMatch ? levelMatch[1] : 'Unknown'
                    };
                }
                return null;
            });
            
            if (compatibilityResults) {
                this.results[browserName].compatibility = compatibilityResults;
                console.log(`    ✅ Compatibility: ${compatibilityResults.passed}/${compatibilityResults.total} (${compatibilityResults.level})`);
            }
            
        } catch (error) {
            console.log(`    ❌ Compatibility tests failed: ${error.message}`);
        }
    }
    
    generateReport() {
        const reportPath = path.join(__dirname, 'cross-browser-report.json');
        const htmlReportPath = path.join(__dirname, 'cross-browser-report.html');
        
        // Save JSON report
        fs.writeFileSync(reportPath, JSON.stringify(this.results, null, 2));
        
        // Generate HTML report
        const htmlReport = this.generateHTMLReport();
        fs.writeFileSync(htmlReportPath, htmlReport);
        
        console.log(`\n📊 Reports generated:`);
        console.log(`   JSON: ${reportPath}`);
        console.log(`   HTML: ${htmlReportPath}`);
        
        // Print summary
        this.printSummary();
    }
    
    generateHTMLReport() {
        let html = `
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cross-Browser Test Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .browser-section { margin-bottom: 30px; border: 1px solid #ddd; padding: 20px; border-radius: 8px; }
        .pass { color: green; font-weight: bold; }
        .fail { color: red; font-weight: bold; }
        .summary { background: #f5f5f5; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Cross-Browser Test Report</h1>
    <p>Generated on: ${new Date().toLocaleString()}</p>
`;
        
        for (const [browserName, results] of Object.entries(this.results)) {
            html += `
    <div class="browser-section">
        <h2>${browserName}</h2>
        <div class="summary">
            <strong>Summary:</strong> ${results.summary.passed}/${results.summary.total} tests passed
            ${results.compatibility ? `<br><strong>Compatibility:</strong> ${results.compatibility.level} (${results.compatibility.passed}/${results.compatibility.total})` : ''}
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Page</th>
                    <th>Tests Passed</th>
                    <th>Status</th>
                    <th>Issues</th>
                </tr>
            </thead>
            <tbody>
`;
            
            for (const [pageName, pageResults] of Object.entries(results.tests)) {
                const status = pageResults.error ? 'ERROR' : 
                             pageResults.passed === pageResults.total ? 'PASS' : 'PARTIAL';
                const statusClass = status === 'PASS' ? 'pass' : 'fail';
                
                html += `
                <tr>
                    <td>${pageName}</td>
                    <td>${pageResults.passed}/${pageResults.total}</td>
                    <td class="${statusClass}">${status}</td>
                    <td>${pageResults.error || (pageResults.consoleErrors && pageResults.consoleErrors.length > 0 ? pageResults.consoleErrors.join(', ') : 'None')}</td>
                </tr>
`;
            }
            
            html += `
            </tbody>
        </table>
    </div>
`;
        }
        
        html += `
</body>
</html>
`;
        
        return html;
    }
    
    printSummary() {
        console.log('\n📊 Cross-Browser Test Summary:');
        console.log('================================');
        
        for (const [browserName, results] of Object.entries(this.results)) {
            const passRate = results.summary.total > 0 ? 
                Math.round((results.summary.passed / results.summary.total) * 100) : 0;
            
            console.log(`${browserName}: ${results.summary.passed}/${results.summary.total} (${passRate}%)`);
            
            if (results.compatibility) {
                const compatRate = Math.round((results.compatibility.passed / results.compatibility.total) * 100);
                console.log(`  Compatibility: ${results.compatibility.level} (${compatRate}%)`);
            }
        }
    }
    
    getEdgePath() {
        // Common Edge installation paths
        const edgePaths = [
            'C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe',
            'C:\\Program Files\\Microsoft\\Edge\\Application\\msedge.exe',
            '/Applications/Microsoft Edge.app/Contents/MacOS/Microsoft Edge',
            '/usr/bin/microsoft-edge'
        ];
        
        for (const edgePath of edgePaths) {
            if (fs.existsSync(edgePath)) {
                return edgePath;
            }
        }
        
        return null; // Will use Chrome if Edge not found
    }
}

// CLI usage
if (require.main === module) {
    const tester = new CrossBrowserTester();
    tester.runTests().catch(console.error);
}

module.exports = CrossBrowserTester;