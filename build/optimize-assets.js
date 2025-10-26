/**
 * Asset Optimization Build Script
 * Minifies CSS, JavaScript, and optimizes images
 */

const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');

class AssetOptimizer {
    constructor() {
        this.rootDir = path.join(__dirname, '..');
        this.buildDir = path.join(this.rootDir, 'dist');
        this.assetsDir = path.join(this.rootDir, 'assets');
        
        this.config = {
            css: {
                input: [
                    'assets/css/critical.css',
                    'assets/css/main.css'
                ],
                output: 'dist/css/app.min.css'
            },
            js: {
                input: [
                    'assets/js/theme-manager.js',
                    'assets/js/keyboard-navigation.js',
                    'assets/js/table-keyboard-nav.js',
                    'assets/js/lazy-loading.js'
                ],
                output: 'dist/js/app.min.js'
            },
            images: {
                input: 'images/',
                output: 'dist/images/',
                formats: ['.jpg', '.jpeg', '.png', '.gif', '.svg']
            }
        };
    }
    
    async optimize() {
        console.log('🚀 Starting asset optimization...');
        
        try {
            this.createDirectories();
            await this.optimizeCSS();
            await this.optimizeJavaScript();
            await this.optimizeImages();
            await this.generateManifest();
            
            console.log('✅ Asset optimization completed successfully!');
        } catch (error) {
            console.error('❌ Asset optimization failed:', error);
            process.exit(1);
        }
    }
    
    createDirectories() {
        const dirs = [
            this.buildDir,
            path.join(this.buildDir, 'css'),
            path.join(this.buildDir, 'js'),
            path.join(this.buildDir, 'images')
        ];
        
        dirs.forEach(dir => {
            if (!fs.existsSync(dir)) {
                fs.mkdirSync(dir, { recursive: true });
                console.log(`📁 Created directory: ${dir}`);
            }
        });
    }
    
    async optimizeCSS() {
        console.log('🎨 Optimizing CSS...');
        
        let combinedCSS = '';
        
        // Combine CSS files
        for (const inputFile of this.config.css.input) {
            const filePath = path.join(this.rootDir, inputFile);
            if (fs.existsSync(filePath)) {
                const content = fs.readFileSync(filePath, 'utf8');
                combinedCSS += `/* ${inputFile} */\n${content}\n\n`;
                console.log(`📄 Added: ${inputFile}`);
            } else {
                console.warn(`⚠️  File not found: ${inputFile}`);
            }
        }
        
        // Minify CSS
        const minifiedCSS = this.minifyCSS(combinedCSS);
        
        // Write minified CSS
        const outputPath = path.join(this.rootDir, this.config.css.output);
        fs.writeFileSync(outputPath, minifiedCSS);
        
        const originalSize = Buffer.byteLength(combinedCSS, 'utf8');
        const minifiedSize = Buffer.byteLength(minifiedCSS, 'utf8');
        const savings = ((originalSize - minifiedSize) / originalSize * 100).toFixed(1);
        
        console.log(`✨ CSS optimized: ${originalSize} → ${minifiedSize} bytes (${savings}% reduction)`);
    }
    
    async optimizeJavaScript() {
        console.log('⚡ Optimizing JavaScript...');
        
        let combinedJS = '';
        
        // Combine JS files
        for (const inputFile of this.config.js.input) {
            const filePath = path.join(this.rootDir, inputFile);
            if (fs.existsSync(filePath)) {
                const content = fs.readFileSync(filePath, 'utf8');
                combinedJS += `/* ${inputFile} */\n${content}\n\n`;
                console.log(`📄 Added: ${inputFile}`);
            } else {
                console.warn(`⚠️  File not found: ${inputFile}`);
            }
        }
        
        // Minify JavaScript
        const minifiedJS = this.minifyJS(combinedJS);
        
        // Write minified JS
        const outputPath = path.join(this.rootDir, this.config.js.output);
        fs.writeFileSync(outputPath, minifiedJS);
        
        const originalSize = Buffer.byteLength(combinedJS, 'utf8');
        const minifiedSize = Buffer.byteLength(minifiedJS, 'utf8');
        const savings = ((originalSize - minifiedSize) / originalSize * 100).toFixed(1);
        
        console.log(`✨ JavaScript optimized: ${originalSize} → ${minifiedSize} bytes (${savings}% reduction)`);
    }
    
    async optimizeImages() {
        console.log('🖼️  Optimizing images...');
        
        const inputDir = path.join(this.rootDir, this.config.images.input);
        const outputDir = path.join(this.rootDir, this.config.images.output);
        
        if (!fs.existsSync(inputDir)) {
            console.warn(`⚠️  Images directory not found: ${inputDir}`);
            return;
        }
        
        const files = this.getAllFiles(inputDir);
        const imageFiles = files.filter(file => 
            this.config.images.formats.some(format => 
                file.toLowerCase().endsWith(format)
            )
        );
        
        for (const imageFile of imageFiles) {
            const relativePath = path.relative(inputDir, imageFile);
            const outputPath = path.join(outputDir, relativePath);
            const outputDirPath = path.dirname(outputPath);
            
            // Create output directory if it doesn't exist
            if (!fs.existsSync(outputDirPath)) {
                fs.mkdirSync(outputDirPath, { recursive: true });
            }
            
            // Copy and optimize image
            await this.optimizeImage(imageFile, outputPath);
        }
        
        console.log(`✨ Optimized ${imageFiles.length} images`);
    }
    
    async optimizeImage(inputPath, outputPath) {
        const ext = path.extname(inputPath).toLowerCase();
        
        try {
            if (ext === '.svg') {
                // For SVG, just copy and minify
                const content = fs.readFileSync(inputPath, 'utf8');
                const minified = this.minifySVG(content);
                fs.writeFileSync(outputPath, minified);
            } else {
                // For other images, copy as-is (in production, you'd use imagemin)
                fs.copyFileSync(inputPath, outputPath);
            }
            
            const originalSize = fs.statSync(inputPath).size;
            const optimizedSize = fs.statSync(outputPath).size;
            const savings = originalSize > optimizedSize ? 
                ((originalSize - optimizedSize) / originalSize * 100).toFixed(1) : 0;
            
            console.log(`📸 ${path.basename(inputPath)}: ${originalSize} → ${optimizedSize} bytes (${savings}% reduction)`);
        } catch (error) {
            console.error(`❌ Failed to optimize ${inputPath}:`, error.message);
            // Fallback: just copy the file
            fs.copyFileSync(inputPath, outputPath);
        }
    }
    
    async generateManifest() {
        console.log('📋 Generating asset manifest...');
        
        const manifest = {
            version: Date.now(),
            files: {
                css: 'dist/css/app.min.css',
                js: 'dist/js/app.min.js'
            },
            integrity: {
                css: this.generateIntegrity(path.join(this.rootDir, this.config.css.output)),
                js: this.generateIntegrity(path.join(this.rootDir, this.config.js.output))
            },
            generated: new Date().toISOString()
        };
        
        const manifestPath = path.join(this.buildDir, 'manifest.json');
        fs.writeFileSync(manifestPath, JSON.stringify(manifest, null, 2));
        
        console.log('✨ Asset manifest generated');
    }
    
    minifyCSS(css) {
        return css
            // Remove comments
            .replace(/\/\*[\s\S]*?\*\//g, '')
            // Remove unnecessary whitespace
            .replace(/\s+/g, ' ')
            // Remove whitespace around certain characters
            .replace(/\s*([{}:;,>+~])\s*/g, '$1')
            // Remove trailing semicolons
            .replace(/;}/g, '}')
            // Remove empty rules
            .replace(/[^{}]+{\s*}/g, '')
            .trim();
    }
    
    minifyJS(js) {
        return js
            // Remove single-line comments (but preserve URLs)
            .replace(/(?:^|\s)\/\/(?![^\r\n]*https?:).*$/gm, '')
            // Remove multi-line comments
            .replace(/\/\*[\s\S]*?\*\//g, '')
            // Remove unnecessary whitespace
            .replace(/\s+/g, ' ')
            // Remove whitespace around operators and punctuation
            .replace(/\s*([{}();,=+\-*/<>!&|])\s*/g, '$1')
            .trim();
    }
    
    minifySVG(svg) {
        return svg
            // Remove XML comments
            .replace(/<!--[\s\S]*?-->/g, '')
            // Remove unnecessary whitespace
            .replace(/\s+/g, ' ')
            // Remove whitespace between tags
            .replace(/>\s+</g, '><')
            .trim();
    }
    
    getAllFiles(dir) {
        const files = [];
        const items = fs.readdirSync(dir);
        
        for (const item of items) {
            const fullPath = path.join(dir, item);
            const stat = fs.statSync(fullPath);
            
            if (stat.isDirectory()) {
                files.push(...this.getAllFiles(fullPath));
            } else {
                files.push(fullPath);
            }
        }
        
        return files;
    }
    
    generateIntegrity(filePath) {
        if (!fs.existsSync(filePath)) {
            return null;
        }
        
        const crypto = require('crypto');
        const content = fs.readFileSync(filePath);
        const hash = crypto.createHash('sha384').update(content).digest('base64');
        return `sha384-${hash}`;
    }
}

// CLI usage
if (require.main === module) {
    const optimizer = new AssetOptimizer();
    optimizer.optimize();
}

module.exports = AssetOptimizer;