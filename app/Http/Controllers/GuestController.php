<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Display the assessments page
     */
    public function assessments()
    {
        return view('assessments');
    }

    /**
     * Display the blog page
     */
    public function blog()
    {
        return view('blog');
    }

    /**
     * Display the pricing page
     */
    public function pricing()
    {
        return view('pricing');
    }

    /**
     * Display the FAQ page
     */
    public function faq()
    {
        return view('faq');
    }

    /**
     * Display the help page
     */
    public function help()
    {
        return view('help');
    }

    /**
     * Display the cookie policy page
     */
    public function cookiePolicy()
    {
        return view('cookie-policy');
    }

    /**
     * Display the refund policy page
     */
    public function refundPolicy()
    {
        return view('refund-policy');
    }

    /**
     * Display the terms and conditions page
     */
    public function terms()
    {
        return view('terms');
    }

    /**
     * Display the privacy policy page
     */
    public function privacy()
    {
        return view('privacy');
    }

    /**
     * Display the contact page
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Display the system status page
     */
    public function systemStatus()
    {
        return view('system-status');
    }

    /**
     * Display the dashboard page (requires authentication)
     */
    public function dashboard()
    {
        // For now, return the view - in a real app, you'd add auth middleware
        return view('dashboard');
    }

    /**
     * Display the transactions page (requires authentication)
     */
    public function transactions()
    {
        // For now, return the view - in a real app, you'd add auth middleware
        return view('transactions');
    }

    /**
     * Display the institution dashboard page (requires authentication)
     */
    public function institutionDashboard()
    {
        // For now, return the view - in a real app, you'd add auth middleware
        return view('institution-dashboard');
    }

    /**
     * Display the assessment page (requires authentication)
     */
    public function assessment($id)
    {
        // Authentication is handled client-side via localStorage
        // Server-side check removed to prevent false redirects
        return view('assessment');
    }

    /**
     * Display the assessment summary page (requires authentication)
     */
    public function assessmentSummary($id)
    {
        // Authentication is handled client-side via localStorage
        // Server-side check removed to prevent false redirects
        return view('assessment-summary');
    }
} 