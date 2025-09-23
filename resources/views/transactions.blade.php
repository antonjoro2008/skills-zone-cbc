@extends('layouts.app')

@section('title', 'Transaction History - Gravity CBC')

@section('content')
    <!-- Hero Section -->
    <div class="gradient-bg text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 text-center">
            <h1 class="text-4xl font-bold mb-4">Transaction History</h1>
            <p class="text-xl text-gray-100">View your payment history and token purchases</p>
        </div>
    </div>
    
    <!-- Transactions Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-coins text-blue-600 text-2xl"></i>
                    </div>
                    <p class="text-sm text-gray-500">Total Spent</p>
                    <p class="text-2xl font-bold text-gray-900" id="totalSpent">
                        <i class="fas fa-spinner fa-spin"></i>
                    </p>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shopping-cart text-green-600 text-2xl"></i>
                    </div>
                    <p class="text-sm text-gray-500">Total Purchases</p>
                    <p class="text-2xl font-bold text-gray-900" id="totalPurchases">
                        <i class="fas fa-spinner fa-spin"></i>
                    </p>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar text-purple-600 text-2xl"></i>
                    </div>
                    <p class="text-sm text-gray-500">This Month</p>
                    <p class="text-2xl font-bold text-gray-900" id="thisMonthSpent">
                        <i class="fas fa-spinner fa-spin"></i>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Additional Summary Cards for Institution Users -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8" id="institutionSummaryCards" style="display: none;">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-yellow-600 text-2xl"></i>
                    </div>
                    <p class="text-sm text-gray-500">Total Students</p>
                    <p class="text-2xl font-bold text-gray-900" id="totalStudents">
                        <i class="fas fa-spinner fa-spin"></i>
                    </p>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-coins text-indigo-600 text-2xl"></i>
                    </div>
                    <p class="text-sm text-gray-500">Tokens Credited</p>
                    <p class="text-2xl font-bold text-gray-900" id="totalTokensCredited">
                        <i class="fas fa-spinner fa-spin"></i>
                    </p>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-red-600 text-2xl"></i>
                    </div>
                    <p class="text-sm text-gray-500">Tokens Used</p>
                    <p class="text-2xl font-bold text-gray-900" id="totalTokensUsed">
                        <i class="fas fa-spinner fa-spin"></i>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Transaction List -->
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Recent Transactions</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Current Balance:</span>
                    <span class="text-lg font-bold text-blue-600" id="currentBalance">
                        <i class="fas fa-spinner fa-spin"></i>
                    </span>
                </div>
            </div>
            
            <!-- Loading State -->
            <div id="transactionsLoading" class="space-y-4">
                <div class="animate-pulse">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gray-200 rounded-lg mr-4"></div>
                            <div>
                                <div class="h-4 bg-gray-200 rounded w-48 mb-2"></div>
                                <div class="h-3 bg-gray-200 rounded w-32"></div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="h-4 bg-gray-200 rounded w-20 mb-2"></div>
                            <div class="h-3 bg-gray-200 rounded w-16"></div>
                        </div>
                    </div>
                </div>
                <div class="animate-pulse">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gray-200 rounded-lg mr-4"></div>
                            <div>
                                <div class="h-4 bg-gray-200 rounded w-48 mb-2"></div>
                                <div class="h-3 bg-gray-200 rounded w-32"></div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="h-4 bg-gray-200 rounded w-20 mb-2"></div>
                            <div class="h-3 bg-gray-200 rounded w-16"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Transactions Grid -->
            <div id="transactionsGrid" class="space-y-4" style="display: none;">
                <!-- Dynamic transactions will be rendered here -->
            </div>
            
            <!-- Empty State -->
            <div id="transactionsEmpty" class="text-center py-12" style="display: none;">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-receipt text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Transactions Yet</h3>
                <p class="text-gray-500">Your transaction history will appear here once you start making purchases or taking assessments.</p>
            </div>
            
            <!-- Error State -->
            <div id="transactionsError" class="text-center py-12" style="display: none;">
                <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Unable to Load Transactions</h3>
                <p class="text-gray-500 mb-4">There was an error loading your transaction history. Please try again.</p>
                <button onclick="loadTransactions()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Try Again
                </button>
            </div>
            
            <!-- Load More Button -->
            <div class="text-center mt-8" id="loadMoreContainer" style="display: none;">
                <button id="loadMoreBtn" onclick="loadMoreTransactions()" class="bg-white border-2 border-blue-600 text-blue-600 px-8 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all">
                    Load More Transactions
                </button>
            </div>
        </div>
        
        <!-- Export Options -->
        <div class="mt-8 text-center">
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-3xl p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Export Your Data</h3>
                <p class="text-gray-600 mb-6">Download your transaction history for record keeping</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button id="exportPdfBtn" onclick="exportToPDF()" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-download mr-2"></i>
                        <span id="pdfBtnText">Export as PDF</span>
                    </button>
                    <button id="exportCsvBtn" onclick="exportToCSV()" class="bg-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-file-excel mr-2"></i>
                        <span id="csvBtnText">Export as CSV</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    let currentPage = 1;
    let isLoading = false;
    let hasMorePages = false;
    let userType = 'individual'; // Default to individual

    document.addEventListener('DOMContentLoaded', function() {
        // Determine user type from localStorage
        const currentUser = JSON.parse(localStorage.getItem('user') || 'null');
        
        // Prevent institutional learners from accessing transactions page
        if (currentUser && currentUser.user_type === 'student' && currentUser.institution_id) {
            alert('Access denied. Institutional learners cannot access transaction history.');
            window.location.href = '/dashboard';
            return;
        }
        
        if (currentUser && currentUser.user_type === 'institution') {
            userType = 'institution';
            // Show institution-specific summary cards
            document.getElementById('institutionSummaryCards').style.display = 'grid';
        }
        
        // Wait a bit to ensure all modals are loaded
        setTimeout(() => {
            loadTransactions();
        }, 100);
    });

    async function loadTransactions(page = 1) {
        if (isLoading) return;
        
        isLoading = true;
        currentPage = page;
        
        // Show loading state
        showLoadingState();
        
        try {
            const token = localStorage.getItem('token');
            if (!token) {
                throw new Error('No authentication token found');
            }
            
            // Determine endpoint based on user type
            const endpoint = userType === 'institution' 
                ? `${API_BASE_URL}/api/institution/transactions`
                : `${API_BASE_URL}/api/my-transactions`;
            
            const response = await fetch(`${endpoint}?page=${page}&per_page=20`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            
            if (data.success && data.data) {
                updateSummaryCards(data.data.summary);
                renderTransactions(data.data.transactions);
                updatePagination(data.data.transactions);
                storeTransactionData(data.data.transactions, data.data.summary);
            } else {
                showErrorState();
            }
        } catch (error) {
            console.error('Error loading transactions:', error);
            showErrorState();
        } finally {
            isLoading = false;
        }
    }

    function showLoadingState() {
        document.getElementById('transactionsLoading').style.display = 'block';
        document.getElementById('transactionsGrid').style.display = 'none';
        document.getElementById('transactionsEmpty').style.display = 'none';
        document.getElementById('transactionsError').style.display = 'none';
        document.getElementById('loadMoreContainer').style.display = 'none';
    }

    function showErrorState() {
        document.getElementById('transactionsLoading').style.display = 'none';
        document.getElementById('transactionsGrid').style.display = 'none';
        document.getElementById('transactionsEmpty').style.display = 'none';
        document.getElementById('transactionsError').style.display = 'block';
        document.getElementById('loadMoreContainer').style.display = 'none';
    }

    async function loadCurrentTokenBalance() {
        try {
            const token = localStorage.getItem('token');
            if (!token) {
                document.getElementById('currentBalance').textContent = '0 tokens';
                return;
            }

            const response = await fetch(`${API_BASE_URL}/api/token-balance`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });

            const data = await response.json();
            
            if (data.success && data.data) {
                document.getElementById('currentBalance').textContent = `${data.data.token_balance || 0} tokens`;
            } else {
                document.getElementById('currentBalance').textContent = '0 tokens';
            }
        } catch (error) {
            console.error('Error loading current token balance:', error);
            document.getElementById('currentBalance').textContent = '0 tokens';
        }
    }

    function updateSummaryCards(summary) {
        // Update common summary cards
        document.getElementById('totalSpent').textContent = `KSH ${summary.total_spent || '0.00'}`;
        document.getElementById('totalPurchases').textContent = summary.total_purchases || '0';
        document.getElementById('thisMonthSpent').textContent = `KSH ${summary.this_month_spent || '0.00'}`;
        
        // Load current balance from the correct API endpoint
        loadCurrentTokenBalance();
        
        // Update institution-specific cards if user is institution
        if (userType === 'institution') {
            document.getElementById('totalStudents').textContent = summary.total_students || '0';
            document.getElementById('totalTokensCredited').textContent = summary.total_tokens_credited || '0';
            document.getElementById('totalTokensUsed').textContent = summary.total_tokens_used || '0';
        }
    }

    function renderTransactions(transactionsData) {
        const gridElement = document.getElementById('transactionsGrid');
        if (!gridElement) return;
        
        if (currentPage === 1) {
            gridElement.innerHTML = '';
        }
        
        if (transactionsData.data && transactionsData.data.length > 0) {
            transactionsData.data.forEach(transaction => {
                gridElement.innerHTML += createTransactionElement(transaction);
            });
            
            document.getElementById('transactionsLoading').style.display = 'none';
            document.getElementById('transactionsGrid').style.display = 'block';
            document.getElementById('transactionsEmpty').style.display = 'none';
            document.getElementById('transactionsError').style.display = 'none';
        } else if (currentPage === 1) {
            // Only show empty state on first page
            document.getElementById('transactionsLoading').style.display = 'none';
            document.getElementById('transactionsGrid').style.display = 'none';
            document.getElementById('transactionsEmpty').style.display = 'block';
            document.getElementById('transactionsError').style.display = 'none';
        }
    }

    function createTransactionElement(transaction) {
        const isCredit = transaction.type === 'credit';
        const isDebit = transaction.type === 'debit';
        
        // Determine icon and colors based on transaction type
        let iconClass, bgColor, textColor, statusColor;
        
        if (isCredit) {
            iconClass = 'fas fa-plus-circle';
            bgColor = 'bg-green-100';
            textColor = 'text-green-600';
            statusColor = 'text-green-600';
        } else if (isDebit) {
            iconClass = 'fas fa-minus-circle';
            bgColor = 'bg-red-100';
            textColor = 'text-red-600';
            statusColor = 'text-red-600';
        } else {
            iconClass = 'fas fa-exchange-alt';
            bgColor = 'bg-blue-100';
            textColor = 'text-blue-600';
            statusColor = 'text-blue-600';
        }
        
        // Format date
        const date = new Date(transaction.date);
        const formattedDate = date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        // Format amount
        const amount = transaction.amount ? `KSH ${transaction.amount}` : 'N/A';
        
        // Format tokens
        const tokens = transaction.tokens ? `${transaction.tokens > 0 ? '+' : ''}${transaction.tokens} tokens` : '';
        
        // Get transaction description
        const description = transaction.description || transaction.transaction_type || 'Transaction';
        
        // Student info for institution users
        const studentInfo = userType === 'institution' && transaction.student_name 
            ? `<p class="text-xs text-gray-400">Student: ${transaction.student_name}</p>` 
            : '';
        
        // Assessment info for assessment attempts
        const assessmentInfo = transaction.assessment_title 
            ? `<p class="text-xs text-gray-400">Assessment: ${transaction.assessment_title}</p>`
            : '';
        
        // Score info for completed assessments
        const scoreInfo = transaction.score 
            ? `<p class="text-xs text-gray-400">Score: ${transaction.score}%</p>`
            : '';

        return `
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                <div class="flex items-center">
                    <div class="w-12 h-12 ${bgColor} rounded-lg flex items-center justify-center mr-4">
                        <i class="${iconClass} ${textColor}"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">${description}</p>
                        <p class="text-sm text-gray-500">${formattedDate} ${tokens ? '• ' + tokens : ''}</p>
                        ${studentInfo}
                        ${assessmentInfo}
                        ${scoreInfo}
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-semibold text-gray-900">${amount}</p>
                    <p class="text-sm ${statusColor} capitalize">${transaction.status || 'completed'}</p>
                    ${transaction.reference ? `<p class="text-xs text-gray-400">Ref: ${transaction.reference}</p>` : ''}
                </div>
            </div>
        `;
    }

    function updatePagination(transactionsData) {
        hasMorePages = transactionsData.current_page < transactionsData.last_page;
        
        if (hasMorePages) {
            document.getElementById('loadMoreContainer').style.display = 'block';
        } else {
            document.getElementById('loadMoreContainer').style.display = 'none';
        }
    }

    function loadMoreTransactions() {
        if (!isLoading && hasMorePages) {
            loadTransactions(currentPage + 1);
        }
    }

    // Export functions
    let allTransactionsData = [];
    let summaryData = {};

    function exportToPDF() {
        if (allTransactionsData.length === 0) {
            showAlert('No Data Available', 'No transaction data available to export. Please wait for data to load.', 'warning');
            return;
        }

        setExportLoading('pdf', true);
        
        try {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            
            // Set up document
            doc.setFontSize(20);
            doc.text('Transaction History Report', 20, 20);
            
            // Add user info
            const currentUser = JSON.parse(localStorage.getItem('user') || 'null');
            const reportType = userType === 'institution' ? 'Institution' : 'Individual';
            doc.setFontSize(12);
            doc.text(`Report Type: ${reportType}`, 20, 35);
            if (currentUser) {
                doc.text(`User: ${currentUser.name}`, 20, 45);
                doc.text(`Email: ${currentUser.email}`, 20, 55);
            }
            doc.text(`Generated: ${new Date().toLocaleDateString()}`, 20, 65);
            
            // Add summary section
            doc.setFontSize(16);
            doc.text('Summary', 20, 85);
            doc.setFontSize(10);
            
            const summaryY = 95;
            let yPos = summaryY;
            doc.text(`Total Spent: KSH ${summaryData.total_spent || '0.00'}`, 20, yPos);
            yPos += 10;
            doc.text(`Total Purchases: ${summaryData.total_purchases || '0'}`, 20, yPos);
            yPos += 10;
            doc.text(`This Month Spent: KSH ${summaryData.this_month_spent || '0.00'}`, 20, yPos);
            yPos += 10;
            doc.text(`Current Balance: ${summaryData.current_balance || 0} tokens`, 20, yPos);
            
            if (userType === 'institution') {
                yPos += 10;
                doc.text(`Total Students: ${summaryData.total_students || '0'}`, 20, yPos);
                yPos += 10;
                doc.text(`Tokens Credited: ${summaryData.total_tokens_credited || '0'}`, 20, yPos);
                yPos += 10;
                doc.text(`Tokens Used: ${summaryData.total_tokens_used || '0'}`, 20, yPos);
            }
            
            // Add transactions table
            doc.setFontSize(16);
            doc.text('Transaction Details', 20, yPos + 20);
            
            // Prepare table data
            const tableData = allTransactionsData.map(transaction => {
                const date = new Date(transaction.date).toLocaleDateString();
                const amount = transaction.amount ? `KSH ${transaction.amount}` : 'N/A';
                const tokens = transaction.tokens ? `${transaction.tokens > 0 ? '+' : ''}${transaction.tokens}` : '';
                const studentInfo = userType === 'institution' && transaction.student_name ? transaction.student_name : '';
                
                return [
                    date,
                    transaction.transaction_type || 'Transaction',
                    amount,
                    tokens,
                    transaction.status || 'completed',
                    studentInfo
                ];
            });
            
            // Create table
            doc.autoTable({
                head: [['Date', 'Type', 'Amount', 'Tokens', 'Status', userType === 'institution' ? 'Student' : '']],
                body: tableData,
                startY: yPos + 30,
                styles: { fontSize: 8 },
                headStyles: { fillColor: [59, 130, 246] },
                alternateRowStyles: { fillColor: [248, 250, 252] }
            });
            
            // Save the PDF
            const fileName = `transactions_${userType}_${new Date().toISOString().split('T')[0]}.pdf`;
            doc.save(fileName);
            
        } catch (error) {
            console.error('Error generating PDF:', error);
            showAlert('Export Error', 'Error generating PDF. Please try again.', 'error');
        } finally {
            setExportLoading('pdf', false);
        }
    }

    function exportToCSV() {
        if (allTransactionsData.length === 0) {
            showAlert('No Data Available', 'No transaction data available to export. Please wait for data to load.', 'warning');
            return;
        }

        setExportLoading('csv', true);
        
        try {
            // Prepare CSV headers
            const headers = [
                'Date',
                'Transaction Type',
                'Amount (KSH)',
                'Tokens',
                'Status',
                'Description',
                'Reference'
            ];
            
            if (userType === 'institution') {
                headers.push('Student Name', 'Student ID');
            }
            
            if (userType === 'individual') {
                headers.push('Assessment Title', 'Score (%)');
            }
            
            // Prepare CSV data
            const csvData = allTransactionsData.map(transaction => {
                const date = new Date(transaction.date).toLocaleDateString();
                const amount = transaction.amount || '';
                const tokens = transaction.tokens || '';
                const description = transaction.description || '';
                const reference = transaction.reference || '';
                
                const row = [
                    date,
                    transaction.transaction_type || '',
                    amount,
                    tokens,
                    transaction.status || '',
                    description,
                    reference
                ];
                
                if (userType === 'institution') {
                    row.push(transaction.student_name || '', transaction.student_id || '');
                }
                
                if (userType === 'individual') {
                    row.push(transaction.assessment_title || '', transaction.score || '');
                }
                
                return row;
            });
            
            // Add summary data at the top
            const summaryRows = [
                ['TRANSACTION SUMMARY'],
                ['Total Spent (KSH)', summaryData.total_spent || '0.00'],
                ['Total Purchases', summaryData.total_purchases || '0'],
                ['This Month Spent (KSH)', summaryData.this_month_spent || '0.00'],
                ['Current Balance (Tokens)', summaryData.current_balance || '0']
            ];
            
            if (userType === 'institution') {
                summaryRows.push(
                    ['Total Students', summaryData.total_students || '0'],
                    ['Tokens Credited', summaryData.total_tokens_credited || '0'],
                    ['Tokens Used', summaryData.total_tokens_used || '0']
                );
            }
            
            summaryRows.push([''], ['TRANSACTION DETAILS']);
            
            // Combine summary and transaction data
            const allData = [
                ...summaryRows,
                headers,
                ...csvData
            ];
            
            // Convert to CSV string
            const csvContent = allData.map(row => 
                row.map(field => `"${String(field).replace(/"/g, '""')}"`).join(',')
            ).join('\n');
            
            // Create and download file
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            
            const fileName = `transactions_${userType}_${new Date().toISOString().split('T')[0]}.csv`;
            link.setAttribute('download', fileName);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
        } catch (error) {
            console.error('Error generating CSV:', error);
            showAlert('Export Error', 'Error generating CSV. Please try again.', 'error');
        } finally {
            setExportLoading('csv', false);
        }
    }

    function setExportLoading(type, isLoading) {
        const btn = document.getElementById(`export${type.charAt(0).toUpperCase() + type.slice(1)}Btn`);
        const btnText = document.getElementById(`${type}BtnText`);
        
        if (isLoading) {
            btn.disabled = true;
            btnText.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Generating...';
        } else {
            btn.disabled = false;
            btnText.textContent = `Export as ${type.toUpperCase()}`;
        }
    }

    // Store transaction data for export
    function storeTransactionData(transactionsData, summary) {
        if (currentPage === 1) {
            allTransactionsData = [];
        }
        
        if (transactionsData.data) {
            allTransactionsData = allTransactionsData.concat(transactionsData.data);
        }
        
        summaryData = summary;
    }

    // Simple showAlert function for transactions page
    function showAlert(title, message, type = 'warning') {
        // Just use a simple, styled alert for now
        const alertHtml = `
            <div style="
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: white;
                border-radius: 12px;
                padding: 24px;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                z-index: 9999;
                max-width: 400px;
                text-align: center;
                border: 2px solid ${type === 'error' ? '#ef4444' : type === 'success' ? '#10b981' : '#f59e0b'};
            ">
                <div style="
                    width: 48px;
                    height: 48px;
                    border-radius: 50%;
                    background: ${type === 'error' ? '#ef4444' : type === 'success' ? '#10b981' : '#f59e0b'};
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0 auto 16px;
                    color: white;
                    font-size: 20px;
                ">
                    ${type === 'error' ? '⚠️' : type === 'success' ? '✅' : '⚠️'}
                </div>
                <h3 style="margin: 0 0 8px; font-size: 18px; font-weight: bold; color: #1f2937;">${title}</h3>
                <p style="margin: 0 0 20px; color: #6b7280; line-height: 1.5;">${message}</p>
                <button onclick="this.parentElement.remove()" style="
                    background: #3b82f6;
                    color: white;
                    border: none;
                    padding: 10px 20px;
                    border-radius: 8px;
                    font-weight: 500;
                    cursor: pointer;
                    transition: background 0.2s;
                " onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                    OK
                </button>
            </div>
            <div style="
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 9998;
            " onclick="this.remove(); this.nextElementSibling.remove()"></div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', alertHtml);
    }
</script>
@endsection 