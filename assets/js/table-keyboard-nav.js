/**
 * Table Keyboard Navigation Enhancement
 * Provides comprehensive keyboard navigation for data tables
 */

class TableKeyboardNavigation {
    constructor() {
        this.tables = [];
        this.init();
    }
    
    init() {
        this.setupTables();
        this.observeNewTables();
    }
    
    setupTables() {
        const tables = document.querySelectorAll('.modern-table, table[role="grid"]');
        tables.forEach(table => this.enhanceTable(table));
    }
    
    enhanceTable(table) {
        if (table.hasAttribute('data-keyboard-enhanced')) return;
        
        table.setAttribute('data-keyboard-enhanced', 'true');
        table.setAttribute('role', 'grid');
        table.setAttribute('aria-label', 'Bảng dữ liệu có thể điều hướng bằng bàn phím');
        
        // Enhance headers
        this.enhanceHeaders(table);
        
        // Enhance cells
        this.enhanceCells(table);
        
        // Add keyboard event listeners
        this.addTableKeyboardListeners(table);
        
        // Add sorting keyboard support
        this.addSortingKeyboardSupport(table);
        
        this.tables.push(table);
    }
    
    enhanceHeaders(table) {
        const headers = table.querySelectorAll('th');
        headers.forEach((header, index) => {
            header.setAttribute('role', 'columnheader');
            header.setAttribute('tabindex', '0');
            
            // Add sorting attributes if sortable
            if (header.classList.contains('sortable')) {
                header.setAttribute('aria-sort', 'none');
                header.setAttribute('aria-label', 
                    `${header.textContent.trim()}, cột ${index + 1}, có thể sắp xếp`);
            } else {
                header.setAttribute('aria-label', 
                    `${header.textContent.trim()}, cột ${index + 1}`);
            }
        });
    }
    
    enhanceCells(table) {
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach((row, rowIndex) => {
            row.setAttribute('role', 'row');
            row.setAttribute('aria-rowindex', rowIndex + 2); // +2 because header is row 1
            
            const cells = row.querySelectorAll('td');
            cells.forEach((cell, cellIndex) => {
                cell.setAttribute('role', 'gridcell');
                cell.setAttribute('tabindex', '-1');
                cell.setAttribute('aria-describedby', `col-${cellIndex}-header`);
                
                // Make first cell in each row focusable
                if (cellIndex === 0) {
                    cell.setAttribute('tabindex', '0');
                }
                
                // Add interactive elements handling
                const interactiveElements = cell.querySelectorAll('button, a, input, select');
                interactiveElements.forEach(element => {
                    element.setAttribute('tabindex', '-1');
                });
            });
        });
        
        // Set column headers IDs for aria-describedby
        const headers = table.querySelectorAll('th');
        headers.forEach((header, index) => {
            header.id = `col-${index}-header`;
        });
    }
    
    addTableKeyboardListeners(table) {
        table.addEventListener('keydown', (e) => {
            const cell = e.target.closest('td, th');
            if (!cell) return;
            
            const row = cell.parentElement;
            const tbody = row.closest('tbody');
            const thead = table.querySelector('thead');
            
            let targetCell = null;
            let handled = false;
            
            switch (e.key) {
                case 'ArrowRight':
                    targetCell = this.getNextCell(cell, 'right');
                    handled = true;
                    break;
                    
                case 'ArrowLeft':
                    targetCell = this.getNextCell(cell, 'left');
                    handled = true;
                    break;
                    
                case 'ArrowDown':
                    if (cell.tagName === 'TH') {
                        // From header to first data row
                        const firstDataRow = tbody?.querySelector('tr');
                        if (firstDataRow) {
                            const cellIndex = Array.from(row.children).indexOf(cell);
                            targetCell = firstDataRow.children[cellIndex];
                        }
                    } else {
                        targetCell = this.getNextCell(cell, 'down');
                    }
                    handled = true;
                    break;
                    
                case 'ArrowUp':
                    if (cell.tagName === 'TD') {
                        const cellIndex = Array.from(row.children).indexOf(cell);
                        const prevRow = row.previousElementSibling;
                        
                        if (prevRow) {
                            targetCell = prevRow.children[cellIndex];
                        } else if (thead) {
                            // Go to header
                            const headerRow = thead.querySelector('tr');
                            targetCell = headerRow?.children[cellIndex];
                        }
                    }
                    handled = true;
                    break;
                    
                case 'Home':
                    if (e.ctrlKey) {
                        // Go to first cell of table
                        const firstRow = thead?.querySelector('tr') || tbody?.querySelector('tr');
                        targetCell = firstRow?.children[0];
                    } else {
                        // Go to first cell of current row
                        targetCell = row.children[0];
                    }
                    handled = true;
                    break;
                    
                case 'End':
                    if (e.ctrlKey) {
                        // Go to last cell of table
                        const lastRow = tbody?.querySelector('tr:last-child') || thead?.querySelector('tr');
                        if (lastRow) {
                            targetCell = lastRow.children[lastRow.children.length - 1];
                        }
                    } else {
                        // Go to last cell of current row
                        targetCell = row.children[row.children.length - 1];
                    }
                    handled = true;
                    break;
                    
                case 'PageDown':
                    targetCell = this.getPageDownCell(cell, table);
                    handled = true;
                    break;
                    
                case 'PageUp':
                    targetCell = this.getPageUpCell(cell, table);
                    handled = true;
                    break;
                    
                case 'Enter':
                case ' ':
                    if (cell.tagName === 'TH' && cell.classList.contains('sortable')) {
                        e.preventDefault();
                        this.triggerSort(cell);
                        handled = true;
                    } else {
                        // Activate interactive element in cell
                        const interactive = cell.querySelector('button, a, input[type="checkbox"]');
                        if (interactive) {
                            e.preventDefault();
                            interactive.click();
                            handled = true;
                        }
                    }
                    break;
                    
                case 'F2':
                    // Enter edit mode for cell
                    this.enterEditMode(cell);
                    handled = true;
                    break;
                    
                case 'Escape':
                    // Exit edit mode
                    this.exitEditMode(cell);
                    handled = true;
                    break;
            }
            
            if (handled) {
                e.preventDefault();
                
                if (targetCell) {
                    this.focusCell(targetCell);
                    this.announcePosition(targetCell);
                }
            }
        });
        
        // Handle focus events
        table.addEventListener('focusin', (e) => {
            const cell = e.target.closest('td, th');
            if (cell) {
                this.updateCellFocus(cell);
            }
        });
    }
    
    addSortingKeyboardSupport(table) {
        const sortableHeaders = table.querySelectorAll('th.sortable');
        
        sortableHeaders.forEach(header => {
            header.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.triggerSort(header);
                }
            });
        });
    }
    
    getNextCell(currentCell, direction) {
        const row = currentCell.parentElement;
        const table = currentCell.closest('table');
        const tbody = table.querySelector('tbody');
        const cellIndex = Array.from(row.children).indexOf(currentCell);
        
        switch (direction) {
            case 'right':
                return row.children[cellIndex + 1] || null;
                
            case 'left':
                return row.children[cellIndex - 1] || null;
                
            case 'down':
                const nextRow = row.nextElementSibling;
                return nextRow ? nextRow.children[cellIndex] : null;
                
            case 'up':
                const prevRow = row.previousElementSibling;
                return prevRow ? prevRow.children[cellIndex] : null;
                
            default:
                return null;
        }
    }
    
    getPageDownCell(currentCell, table) {
        const row = currentCell.parentElement;
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const currentRowIndex = rows.indexOf(row);
        const cellIndex = Array.from(row.children).indexOf(currentCell);
        
        // Move down by 10 rows or to last row
        const targetRowIndex = Math.min(currentRowIndex + 10, rows.length - 1);
        const targetRow = rows[targetRowIndex];
        
        return targetRow ? targetRow.children[cellIndex] : null;
    }
    
    getPageUpCell(currentCell, table) {
        const row = currentCell.parentElement;
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const currentRowIndex = rows.indexOf(row);
        const cellIndex = Array.from(row.children).indexOf(currentCell);
        
        // Move up by 10 rows or to first row
        const targetRowIndex = Math.max(currentRowIndex - 10, 0);
        const targetRow = rows[targetRowIndex];
        
        return targetRow ? targetRow.children[cellIndex] : null;
    }
    
    focusCell(cell) {
        // Remove tabindex from all cells
        const table = cell.closest('table');
        const allCells = table.querySelectorAll('td, th');
        allCells.forEach(c => c.setAttribute('tabindex', '-1'));
        
        // Set tabindex and focus on target cell
        cell.setAttribute('tabindex', '0');
        cell.focus();
        
        // Scroll into view if needed
        cell.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
            inline: 'nearest'
        });
    }
    
    updateCellFocus(cell) {
        const table = cell.closest('table');
        
        // Remove active class from all cells
        table.querySelectorAll('.cell-focused').forEach(c => {
            c.classList.remove('cell-focused');
        });
        
        // Add active class to current cell
        cell.classList.add('cell-focused');
        
        // Update aria-selected
        table.querySelectorAll('[aria-selected="true"]').forEach(c => {
            c.setAttribute('aria-selected', 'false');
        });
        cell.setAttribute('aria-selected', 'true');
    }
    
    announcePosition(cell) {
        const row = cell.parentElement;
        const table = cell.closest('table');
        const tbody = table.querySelector('tbody');
        const thead = table.querySelector('thead');
        
        const cellIndex = Array.from(row.children).indexOf(cell) + 1;
        let rowIndex;
        
        if (cell.tagName === 'TH') {
            rowIndex = 'tiêu đề';
        } else {
            const rows = Array.from(tbody.querySelectorAll('tr'));
            rowIndex = rows.indexOf(row) + 1;
        }
        
        const columnHeader = thead?.querySelector(`th:nth-child(${cellIndex})`)?.textContent.trim() || `cột ${cellIndex}`;
        
        // Create announcement for screen readers
        const announcement = `${columnHeader}, hàng ${rowIndex}, cột ${cellIndex}`;
        this.announceToScreenReader(announcement);
    }
    
    triggerSort(header) {
        const currentSort = header.getAttribute('aria-sort');
        let newSort;
        
        switch (currentSort) {
            case 'none':
            case 'descending':
                newSort = 'ascending';
                break;
            case 'ascending':
                newSort = 'descending';
                break;
            default:
                newSort = 'ascending';
        }
        
        // Update aria-sort attributes
        const table = header.closest('table');
        table.querySelectorAll('th[aria-sort]').forEach(th => {
            th.setAttribute('aria-sort', 'none');
        });
        header.setAttribute('aria-sort', newSort);
        
        // Trigger the actual sort (if sort function exists)
        if (typeof window.sortTable === 'function') {
            const column = header.dataset.sort;
            const direction = newSort === 'ascending' ? 'asc' : 'desc';
            window.sortTable(column, direction);
        }
        
        // Announce sort change
        const columnName = header.textContent.trim();
        const sortDirection = newSort === 'ascending' ? 'tăng dần' : 'giảm dần';
        this.announceToScreenReader(`Đã sắp xếp ${columnName} theo thứ tự ${sortDirection}`);
    }
    
    enterEditMode(cell) {
        const input = cell.querySelector('input, select, textarea');
        if (input) {
            input.setAttribute('tabindex', '0');
            input.focus();
            cell.classList.add('edit-mode');
        }
    }
    
    exitEditMode(cell) {
        const input = cell.querySelector('input, select, textarea');
        if (input) {
            input.setAttribute('tabindex', '-1');
            cell.focus();
            cell.classList.remove('edit-mode');
        }
    }
    
    announceToScreenReader(message) {
        // Create or update live region for announcements
        let liveRegion = document.getElementById('table-announcements');
        if (!liveRegion) {
            liveRegion = document.createElement('div');
            liveRegion.id = 'table-announcements';
            liveRegion.setAttribute('aria-live', 'polite');
            liveRegion.setAttribute('aria-atomic', 'true');
            liveRegion.className = 'sr-only';
            document.body.appendChild(liveRegion);
        }
        
        liveRegion.textContent = message;
    }
    
    observeNewTables() {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === 1) {
                        const tables = node.matches?.('.modern-table, table[role="grid"]') 
                            ? [node] 
                            : node.querySelectorAll?.('.modern-table, table[role="grid"]') || [];
                            
                        tables.forEach(table => this.enhanceTable(table));
                    }
                });
            });
        });
        
        observer.observe(document.body, { childList: true, subtree: true });
    }
}

// Initialize table keyboard navigation when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.tableKeyboardNav = new TableKeyboardNavigation();
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = TableKeyboardNavigation;
}