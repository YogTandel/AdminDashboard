@php use Carbon\Carbon; @endphp
@extends('layouts.layout')

@section('page-name', 'Weekly Bet Report')

@section('content')
    <div class="container py-4">
        <h4 class="mb-4 text-bolder">Weekly Bet Report</h4>

        <form method="GET" action="{{ route('Weekly-report') }}" class="row g-2 align-items-end mb-4">
            <div class="col-md-4">
                <label for="distributor_id" class="form-label">Select Distributor</label>
                <select name="distributor_id" id="distributor_id" class="form-select">
                    <option value="">Choose distributor</option>
                    @foreach($distributors as $distributor)
                        <option
                            value="{{ $distributor->_id }}" {{ (string)$distributor->_id === (string)$selectedDistributorId ? 'selected' : '' }}>
                            {{ $distributor->player ?? $distributor->name ?? 'Unknown Distributor' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="agent_id" class="form-label">Select Agent</label>
                <select name="agent_id" id="agent_id" class="form-select"
                        data-selected-agent-id="{{ (string)($selectedAgentId ?? '') }}">
                    <option value="">Choose agent</option>
                    @foreach($agents as $agent)
                        <option
                            value="{{ $agent->_id }}" {{ (string)$agent->_id === (string)$selectedAgentId ? 'selected' : '' }}>
                            {{ $agent->player ?? $agent->name ?? 'Unknown Agent' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-auto">
                <label class="form-label d-block invisible mb-2">Actions</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary mb-0">Filter</button>
                    <a href="{{ route('Weekly-report') }}" class="btn btn-outline-secondary mb-0">Reset</a>
                </div>
            </div>
        </form>

        @if($hasSelection)
            <table class="table table-bordered table-striped">
                <thead class="text-center">
                <tr>
                    <th>Date</th>
                    <th>Bet Amount</th>
                    <th>win amount</th>
                    <th>Profit</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dailyTotals as $date => $total)
                    @php
                        $win = $winTotals[$date] ?? 0;
                        $profit = $total - $win;
                    @endphp
                    <tr>
                        <td class="text-center">{{ Carbon::parse($date)->format('d-m-Y') }}</td>
                        <td class="text-center">{{ number_format($total, 2) }}</td>
                        <td class="text-center">{{ number_format($win, 2) }}</td>
                        <td class="text-center">{{ number_format($profit, 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info mb-0">
                Select an agent to view the weekly report.
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const distributorSelect = document.getElementById('distributor_id');
            const agentSelect = document.getElementById('agent_id');
            const initialSelectedAgentId = agentSelect ? (agentSelect.dataset.selectedAgentId || '') : '';
            const getAgentsBaseUrl = @json(url('/get-agents'));

            if (!distributorSelect || !agentSelect) {
                return;
            }

            const setDefaultAgentOption = function (label) {
                agentSelect.innerHTML = `<option value="">${label}</option>`;
                agentSelect.disabled = true;
            };

            const fillAgents = function (agents, selectedValue = '') {
                agentSelect.innerHTML = '<option value="">Choose agent</option>';

                agents.forEach(function (agent) {
                    const option = document.createElement('option');
                    option.value = agent._id;
                    option.textContent = agent.player || agent.name || 'Unknown Agent';

                    if (selectedValue && String(selectedValue) === String(agent._id)) {
                        option.selected = true;
                    }

                    agentSelect.appendChild(option);
                });

                agentSelect.disabled = false;
            };

            const loadAgents = async function (distributorId, preselectAgentId = '') {
                if (!distributorId) {
                    setDefaultAgentOption('Choose distributor first');
                    return;
                }

                setDefaultAgentOption('Loading agents...');

                try {
                    const response = await fetch(`${getAgentsBaseUrl}/${encodeURIComponent(distributorId)}`);
                    if (!response.ok) {
                        setDefaultAgentOption('Unable to load agents');
                        return;
                    }

                    const data = await response.json();

                    if (!Array.isArray(data) || data.length === 0) {
                        setDefaultAgentOption('No agents found');
                        return;
                    }

                    fillAgents(data, preselectAgentId);
                } catch (error) {
                    setDefaultAgentOption('Unable to load agents');
                }
            };

            distributorSelect.addEventListener('change', function () {
                loadAgents(this.value, '');
            });

            loadAgents(distributorSelect.value, initialSelectedAgentId);
        });
    </script>
@endpush

