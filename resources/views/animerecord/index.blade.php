                    <!-- Currently Watching Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Currently Watching</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse($watching as $record)
                                <!-- Completed Section -->
                                <div class="mb-8">
                                    <h3 class="text-lg font-semibold mb-4">Completed</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @forelse($completed as $record)
                                            <!-- Plan to Watch Section -->
                                            <div class="mb-8">
                                                <h3 class="text-lg font-semibold mb-4">Plan to Watch</h3>
                                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                                    @forelse($planToWatch as $record)
                                                        <!-- Dropped Section -->
                                                        <div class="mb-8">
                                                            <h3 class="text-lg font-semibold mb-4">Dropped</h3>
                                                            <div
                                                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                                                @forelse($dropped as $record)
